import React, { useState, useEffect } from "react";
import Player from "@vimeo/player";

const Vimeo = (props) => {
  const [id_video, setId] = useState(props.uri);
  useEffect(() => {
    setId(props.uri);

    var iframe = document.querySelector("iframe");
    var player = new Player(iframe);

    player.on("play", function () {
    });

    player.getVideoTitle().then(function (title) {
    });
  }, [props]);

  return (
    <iframe
      className="vimeo_video"
      src={`https://player.vimeo.com/video/${id_video}?`}
      width="100%"
      height="350px"
      frameborder="0"
      webkitallowfullscreen
      mozallowfullscreen
      allowfullscreen
    ></iframe>
  );
};
export default Vimeo;
