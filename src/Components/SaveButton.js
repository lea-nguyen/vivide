import axios from "axios";
import React, { useEffect, useState } from "react";
import { BsBookmark, BsFillBookmarkFill } from "react-icons/bs";

function SaveButton(props) {
  const [button, setButtonContent] = useState(true);
  const buttonStyle = {
    backgroundColor: "rgba(0,0,0,0)",
    border: "rgba(0,0,0,0)",
  };
  useEffect(() => {
    if (props.saved) {
      // project is saved
      setButtonContent(true);
    } else {
      // project is not saved
      setButtonContent(false);
    }
  }, [props.project_url, props.token, props.saved]);

  const swithSave = () => {
    console.log("oui")
    if (document.cookie) {
      let data = {
        token: props.token,
        video: "",
        project: props.project_url,
        do: true,
      };

      // validate you toke before accessing to someone's information aka you only
      axios
        .post("https://apivivide.leanguyen.fr/validatejwt.php", JSON.stringify(data), {
          headers: {
            "Content-Type": "application/json",
          },
        })
        .then((res) => {
          if (res.data !== "") {
            if (res.data.token !== props.token) {
              props.changeCookie(res.data.token);
            }
            // able to un/save a project
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
                  setButtonContent(true);
                } else {
                  setButtonContent(false);
                }
              });
          }
        });
    } else {
      alert("Connectez-vous pour pouvoir enregistrer ce parcours.");
    }
  };
  if (button) {
    return (
      <button className="save" style={buttonStyle} onClick={swithSave}>
        <BsBookmark className="icone_save" size="25px" color="white" />
      </button>
    );
  } else {
    return (
      <button className="save" style={buttonStyle} onClick={swithSave}>
        <BsFillBookmarkFill className="icone_save" size="25px" color="white" />
      </button>
    );
  }
}

export default SaveButton;
