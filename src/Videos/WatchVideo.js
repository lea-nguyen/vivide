import axios from "axios";
import React, { useEffect, useState } from "react";
import { useParams } from "react-router";
import VideosPlaylist from "./VideosPlaylist";
import BackButton from "../Components/BackButton";
import LikeButton from "../Components/LikeButton";
import Vimeo from "./Vimeo";
import { Helmet } from "react-helmet";

function WatchVideo() {
  // function WatchVideo(){
  const { video_url } = useParams();
  const { project_url } = useParams();
  const [dataVideo, setVideo] = useState([]);
  const [dataProject, setProject] = useState([]);
  const [is_liked, setLiked] = useState(1);

  // COOKIE
  /*FROM https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/
  const name = "token=";
  const cDecoded = decodeURIComponent(document.cookie);
  const cArr = cDecoded.split("; ");
  let token = "";
  cArr.forEach((val) => {
    if (val.indexOf(name) === 0) {
      token = val.substring(name.length);
    }
  });
  /*END OF https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/

  const changeCookie = (newCookie) => {
    if (cArr.length > 3) {
      // the user checked the remember button
      document.cookie = "token=" + newCookie + cArr[1] + cArr[2] + cArr[3];
    } else {
      // the user did not check the remember button
      document.cookie = "token=" + newCookie + cArr[1] + cArr[2] + cArr[3];
    }
  };

  useEffect(() => {
    if (document.cookie !== "") {
      let data = {
        token: token,
        video: video_url,
        project: project_url,
        do: false,
      };

      // validate token before accessing someone's informations aka you only
      axios
        .post("https://apivivide.leanguyen.fr/validatejwt.php", JSON.stringify(data), {
          headers: {
            "Content-Type": "application/json",
          },
        })
        .then((res) => {
          if (res.data !== "") {
            if (res.data.token !== token) {
              if (cArr.length > 3) {
                document.cookie =
                  "token=" + res.data.token + cArr[1] + cArr[2] + cArr[3];
              } else {
                document.cookie =
                  "token=" + res.data.token + cArr[1] + cArr[2] + cArr[3];
              }
            }
            // able un/like video
            axios
              .post(
                "https://apivivide.leanguyen.fr/add_like.php",
                JSON.stringify(data),
                {
                  headers: {
                    "Content-Type": "application/json",
                  },
                }
              )
              .then((response) => {
                if (response.data === 0) {
                  setLiked(false);
                } else {
                  setLiked(true);
                }
              });

            // push project in history
            axios.post(
              "https://apivivide.leanguyen.fr/push_history_projects.php",
              JSON.stringify(data),
              {
                headers: {
                  "Content-Type": "application/json",
                },
              }
            );
            // push video in history
            axios.post(
              "https://apivivide.leanguyen.fr/push_history_video.php",
              JSON.stringify(data),
              {
                headers: {
                  "Content-Type": "application/json",
                },
              }
            );
          }
        });
    }
    // get data of video
    axios.get(`https://apivivide.leanguyen.fr/video.php?`).then((response) => {
      let video = response.data.filter((vid) => vid.video_url.includes(video_url) && vid.video_url.length === video_url.length);
      setVideo(video[0]);
      document.querySelector("#exercice").innerHTML=video.exercice;
    });
    // get data of project
    axios
      .get(`https://apivivide.leanguyen.fr/playlists.php?playlist=${project_url}`)
      .then((response) => setProject(response.data[0]));
  }, [project_url, video_url]);

  return (
    <div className="watch">
      <Helmet>
        <title>{dataVideo.name_video}</title>
        <link
          rel="canonical"
          href={`https://vivide.leanguyen.fr/parcours/${project_url}/v/${video_url}`}
        />
        <meta name="og:title" content={dataVideo.name_video} />
        <meta name="og:description" content={dataVideo.description_vid} />
        <meta name="description" content={dataVideo.description_vid} />
        <meta name="og:image" content="src/images/icon_o.png" />
      </Helmet>
      <section>
        <div className="streaming_video">
          <BackButton linkBack={"../"} />
          <Vimeo uri={dataVideo.uri} />
          <h1>{dataVideo.name_video}</h1>
        </div>
        <div className="description">
          <p>
            Avec <span className="auteur">{dataProject.name_admin}</span>
          </p>
          <p>Description</p>
          <p>{dataVideo.description_vid}</p>
          <p className="like">
            <LikeButton
              token={token}
              changeCookie={changeCookie}
              project_url={project_url}
              liked={is_liked}
              video_url={video_url}
            />
            <span>Liker</span>
          </p>
        </div>
        <div className="ressources">
          <h2>Ressources</h2>
          <p id="exercice"></p>
        </div>
      </section>
      <VideosPlaylist project_url={project_url} />
    </div>
  );
}

export default WatchVideo;
