import React from "react";
import { Link } from "react-router-dom";
import { BsPlayCircle } from "react-icons/bs";
import { BiTimeFive } from "react-icons/bi";

function PreviewProject(props) {
  if (props.data.name_admin !== "") {
    // for not on_going_project
    if (props.data[1] === 0) {
        // if there's no video to project, make alert
      return (
        <Link className={props.class} to="/">
          <div
            onClick={() => {
              alert("Ce projet arrive bientôt !");
            }}
          >
            <img
              className="img contains_img description_preview_project"
              alt=""
              src={props.data.thumbnail_proj}
            />
            <div className="description">
              <h2>{props.data.name_project}</h2>
              <p className="description_preview_project">
                Par <span>{props.data.name_admin}</span>
              </p>
              <p className="description_preview_project pp_description">
                {props.data.description}
              </p>
              <p className="description_preview_project">
                <BsPlayCircle className="icone_stat" size={15} /> {props.data[1]} <BiTimeFive className="icone_stat time" />{" "}
                {props.data[0]}min
              </p>
            </div>
          </div>
        </Link>
      );
    } else {
      return (
        // there's a video for the project
        <Link
          className={props.class}
          to={`/parcours/${props.data.project_url}`}
        >
          <div>
            <img
              className="img contains_img description_preview_project"
              alt=""
              src={props.data.thumbnail_proj}
            />
            <div className="description">
              <h2>{props.data.name_project}</h2>
              <p className="description_preview_project">
                Par <span>{props.data.name_admin}</span>
              </p>
              <p className="description_preview_project pp_description">
                {props.data.description}
              </p>
              <p className="description_preview_project">
                <BsPlayCircle size={15} className="icone_stat" />{" "}
                {props.data[1]} <BiTimeFive className="icone_stat time" />{" "}
                {props.data[0]}min
              </p>
            </div>
          </div>
        </Link>
      );
    }
  } else {
    // for on_going_project
    return (
      <div className={props.class}>
        <div className="description">
          <p className="description-not_log">{props.data.description}</p>
        </div>
      </div>
    );
  }
}

export default PreviewProject;
