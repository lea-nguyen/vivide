import React, { useState, useEffect } from "react";
import ArticleDescription from "./ArticleDescription";
import BackButton from "../Components/BackButton";
import { useParams } from "react-router-dom";
import axios from "axios";
import {Helmet} from 'react-helmet';

const Article = () => {
  const { article_url } = useParams();
  const [data, setData] = useState([]);
  const [date, setDate] = useState("");
  useEffect(() => {
    // manage the menu
    document.querySelector(".disactivate").classList.remove("isActiveLevel1");
    // get the article information with axios
    axios
      .post(
        "https://api.vivide.app/getArticle.php",
        JSON.stringify({ article_url: article_url }),
        {
          headers: {
            "Content-type": "application/json",
          },
        }
      )
      .then((res) => {
        setData(res.data[1]);
        document.querySelector(".article_body").innerHTML=res.data[0];
        let date_arr = res.data[1].date_article.split("-");
        setDate(date_arr[2] + "/" + date_arr[1] + "/" + date_arr[0]);
      });
  }, []);

  return (
    <main className="article_main">
      <Helmet>
          <title>{data.name_article}</title>
          <link rel="canonical" href={`https://vivide.app/${data.article_url}`} />
          <meta name="og:image" content={data.thumbnail_article}/>
          <meta name="og:description" content={`Notre nouvel article sur : ${data.name_article}`}/>
          <meta name="og:title" content={data.name_article}/>
      </Helmet>
      <BackButton linkBack={"../articles"} />
      <div className="article_contain">
        <ArticleDescription data={{ date: date, title: data.article_url, thumbnail: data.thumbnail_article }} />
        <div className="article_body"></div>
      </div>
    </main>
  );
};

export default Article;