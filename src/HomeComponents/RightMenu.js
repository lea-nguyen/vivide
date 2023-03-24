import axios from 'axios';
import React, { useEffect,useState } from 'react';
import { Link, Redirect } from 'react-router-dom';
import { PreviewArticle } from '../Articles/ArticlesList';
import SocialMedia from './SocialMedia';


const NewArticles = () => {
    const [data, setData] = useState([]);
    useEffect(()=>{
        // get all the articles
        axios.get("https://apivivide.leanguyen.fr/getArticles.php")
            .then((res)=>{
                let last = res.data.length-1;
                let list = [res.data[last], res.data[last-1]]
                setData(list);
            })
    },[])
    return (
        <div className="new_articles">
            <h1><Link to="/articles" className='h1'>Articles</Link></h1>
            <p> Nouveautés </p>
            {data.map((article) => (
                <PreviewArticle data={article} key={article.id_article} />
            ))}
        </div>
    )
}

const RightMenu = () => {
        return (
            <div className="home_right_menu">
                <NewArticles />
                <SocialMedia />
            </div>
        )
    
}

export default RightMenu;