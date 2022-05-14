import React from "react";
import { Link } from "react-router-dom";

const PreviewVideo = (props) => {
  return (
    <div>
      <Link to={`/parcours/${props.proj}/v/${props.video.video_url}`}>
        <div className="project">
          <div className="container_img">
            <img
              className="contains_img"
              alt=""
              src={props.video.thumbnail_vid}
            />
          </div>

          <div className="description">
            <h2>{props.video.name_video}</h2>
            <p>{props.video.description_vid}</p>
          </div>
        </div>
      </Link>
    </div>
  );
};

export default PreviewVideo;
