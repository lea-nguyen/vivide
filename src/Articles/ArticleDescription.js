import React from 'react';

const ArticleDescription =(props)=> {
    return (
        <article>
            <meta name="og:image" content={props.data.thumbnail}/>
            <img alt='' className="img_article" src={props.data.thumbnail}/>
            <h1>{props.data.title}</h1>
            <p>Ecrit le {props.data.date}</p>
        </article>
    )
}

export default ArticleDescription; 