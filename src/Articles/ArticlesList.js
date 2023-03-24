import axios from 'axios';
import React, { useState,useEffect } from 'react';
import { Link } from 'react-router-dom';
import BackButton from '../Components/BackButton';
import Filter from '../Components/Filter';
import {Helmet} from 'react-helmet';

const PreviewArticle = (props) => {
    return (
        <Link to={`/articles/${props.data.article_url}`}>
            <div className="article">
                <img className="img_article" src={props.data.thumbnail_article} alt=''/>
                <div className="description_article">
                    <h2>{props.data.name_article}</h2>
                    <p>{props.data.description_article}</p>
                </div>
            </div>
        </Link>
    )
}


function ArticlesList(){
    const [data, setData] = useState([]);
    const [queries, setQueries] = useState([]);
    useEffect(()=>{
        // get all of the articles
        axios.get("https://apivivide.leanguyen.fr/getArticles.php")
            .then((res)=>{
                setData(res.data);
                setQueries(res.data);
            })
        document.querySelector('.button_filter').classList.add("is_filter");
    },[])
    const handleChange=(event)=>{
        const filtersList = document.querySelectorAll('.button_filter');
        filtersList.forEach((filter)=>{
            filter.classList.remove('is_filter');
        })
        event.target.classList.add("is_filter");
        
        // filter project
        if (event.target.getAttribute('id')!==0){
            setQueries(data.filter(article => article.tag === event.target.getAttribute('id')));
        }else{
            setQueries(data)
        }
    }
    return (
        <div className='articles_list'>
            <Helmet>
                <title>Articles</title>
                <link rel="canonical" href="https://vivide.leanguyen.fr/articles" />
            </Helmet>
            <BackButton linkBack={"../"} />
            <h1>Articles</h1>
            <Filter filters={["Tous","Audiovisuel","Design","Développement"]} handleChange={handleChange} />
            <div className="articles">
                {queries.map((article) => (
                    <PreviewArticle data={article} key={article.id_article} />
                ))}
            </div>
        </div>
    )
}

export { ArticlesList, PreviewArticle };