import axios from "axios";
import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import SaveButton from "../Components/SaveButton";
import VideosPlaylist from "../Videos/VideosPlaylist";
import { Helmet } from "react-helmet";
import { BsPlayCircle } from "react-icons/bs";
import { BiTimeFive } from "react-icons/bi";

function ProjectDescription() {
  const { project_url } = useParams();
  const [dataProject, setDataProject] = useState([]);
  const [is_saved, setSave] = useState(1);

  // COOKIE
  /*FROM https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/
  const name = "token=";
  const cDecoded = decodeURIComponent(document.cookie);
  const cArr = cDecoded.split("; ");
  let token = 0;
  cArr.forEach((val) => {
    if (val.indexOf(name) === 0) {
      token = val.substring(name.length);
    }
  });
  /*END OF https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/

  const changeCookie = (newCookie) => {
    if (cArr.length > 3) {
      // if the user want to remember the token
      document.cookie = "token=" + newCookie + cArr[1] + cArr[2] + cArr[3];
    } else {
      // if the user didn't check the remember button
      document.cookie = "token=" + newCookie + cArr[1] + cArr[2] + cArr[3];
    }
  };

  useEffect(() => {
    let data = {
      token: token,
      video: "",
      project: project_url,
      do: false,
    };
    // get all projects
    axios.get("https://apivivide.leanguyen.fr//playlists.php?").then((response) => {
      let data = response.data.filter(
        (project) => project.project_url === project_url
      );
      setDataProject(data[0]);
    });
    // validate token before accessing someone's information aka you only
    axios
      .post("https://apivivide.leanguyen.fr/validatejwt.php", JSON.stringify(data), {
        headers: {
          "Content-Type": "application/json",
        },
      })
      .then((res) => {
        if (res.data !== "") {
          if (res.data.token !== token) {
            changeCookie(res.data.token);
          }
          // add project to your history
          axios
            .post(
              "https://apivivide.leanguyen.fr/push_my_projects.php",
              JSON.stringify(data),
              {
                headers: {
                  "Content-Type": "application/json",
                },
              }
            )
            .then((response) => {
              if (response.data === 0) {
                setSave(false);
              } else {
                setSave(true);
              }
            });
        }
      });
  }, [project_url]);

  return (
    <div className="project_description">
      <Helmet>
        <title>{project_url}</title>
        <link
          rel="canonical"
          href={`https://vivide.leanguyen.fr/parcours/${project_url}`}
        />
        <meta name="og:description" content={dataProject.description} />
        <meta name="description" content={dataProject.description} />
      </Helmet>
      <img className="contains_img" alt="" src={dataProject.thumbnail_proj} />
      <div className="description">
        <h2>{dataProject.name_project}</h2>
        <p className="p_auteur">Avec {dataProject.name_admin}</p>
        <p className="p_description">{dataProject.description}</p>
        <p className="p_stat">
          <BsPlayCircle className="icone_stat" size={15} /> {dataProject[1]}{" "}
          <BiTimeFive className="icone_stat time" /> {dataProject[0]}min
        </p>
      </div>
      <p>
        <SaveButton
          className="icone_save"
          saved={is_saved}
          project_url={project_url}
          token={token}
          changeCookie={changeCookie}
        />
        Enregistré
      </p>
    </div>
  );
}

function Project() {
  const { project_url } = useParams();
  return (
    <div className="inside_project">
      <ProjectDescription />
      <VideosPlaylist project_url={project_url} />
    </div>
  );
}

export default Project;
