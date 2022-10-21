import React, { useEffect, useState } from "react";
import { parseJwt } from "rs-jwt";
import axios from "axios";
import { Helmet } from "react-helmet";
import { NavLink } from "react-router-dom";
import { RiDeleteBin6Line } from "react-icons/ri";

function Settings() {
  const [placeholder, setPlaceholder] = useState({
    email: "john.doe@email.fr",
    pseudo: "Johnny",
    letter: "?",
  });

  //COOKIE
  let token;
  let payload;
  if (document.cookie != "") {
    // get the cookie aka your token access
    /*FROM https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/
    const name = "token=";
    const cDecoded = decodeURIComponent(document.cookie); //to be careful
    const cArr = cDecoded.split("; ");
    cArr.forEach((val) => {
      if (val.indexOf(name) === 0) {
        token = val.substring(name.length);
      }
    });
    /*END OF https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/

    // read the payload of token
    const result = parseJwt(token);
    payload = result.getPayload();
  }

  // FUTURE FUNCTION to switch mode color
  // const switchColors=()=>{
  //   const r = document.querySelector(':root');
  //   if(document.querySelector('#switch').checked){
  //     r.style.setProperty('--main', '#FFFFFF');
  //     r.style.setProperty('--grey-dark', '#E8E8E8');
  //     r.style.setProperty('--violet', '#9D59FF');
  //     r.style.setProperty('--grey-light', '#FFFFFF');
  //     r.style.setProperty('--white', '#000000');
  //   }else{
  //     r.style.setProperty('--main', '#464646');
  //     r.style.setProperty('--grey-dark', '#272727');
  //     r.style.setProperty('--violet', '#AF77FF');
  //     r.style.setProperty('--grey-light', '#323232');
  //     r.style.setProperty('--white', '#FFFFFF');
  //   }
  // }

  useEffect(() => {
    if (document.cookie != "") {
      // if has cookie, disable button save
      document.querySelector("#settingsSave").style.backgroundColor = "#ccc";
      document.querySelector("#settingsSave").style.color = "#808080";
      document.querySelector("#settingsSave").disabled = true;
      setPlaceholder({
        email: payload.usermail,
        pseudo: payload.username,
        letter: payload.username.substring(0, 1),
      });
    }
    // FOR FUTURE FUNCTION switch color mode
    // if(localStorage.getItem('vivide_mode')){
    //   document.querySelector('#switch').checked=true;
    // }else{
    //   document.querySelector('#switch').checked=false;
    // }
  }, []);

  const change = () => {
    // if change an information
    // FOR FUTURE FUNCTION switch color mode
    // let is_checked = document.querySelector('#switch').checked;
    // let previous = localStorage.getItem('vivide_mode');
    if (
      document.querySelector("#inputEmail").value != "" ||
      document.querySelector("#inputName").value != ""
      // FOR FUTURE FUNCTION switch color mode
      //|| is_checked!=previous
    ) {
      // able the button save
      document.querySelector("#settingsSave").style.backgroundColor = "#AF77FF";
      document.querySelector("#settingsSave").style.color = "#363636";
      document.querySelector("#settingsSave").disabled = false;
    }
  };
  const request = () => {
    let data = {
      token: token,
      name: document.querySelector("#inputName").value,
      email: document.querySelector("#inputEmail").value,
    };
    // make the change request 
    if(payload.username !=document.querySelector("#inputName").value || payload.usermail!=document.querySelector("#inputEmail").value){
      axios
        .post("https://apivivide.leanguyen.fr/change_user.php", JSON.stringify(data), {
          headers: {
            "Content-Type": "application/json",
          },
        })
        .then((res) => console.log(res.data));
      if (document.querySelector("#inputEmail").value != "") {
        // if you changed email
        alert(
          "Vous souhaitez modifier votre email. Veuilles consulter vos emails sur votre nouvelle adresse."
        );
      }
    }else{
      alert('Les informations sont identiques.')
    }
    // FOR FUTURE FUNCTION switch color mode
    // let is_dark = document.querySelector('#switch');
    // localStorage.setItem("vivide_mode",is_dark)
  };
  const reset = () => {
    // reset value, don't want to change user's information
    document.querySelector("#inputName").value = "";
    document.querySelector("#inputEmail").value = "";
    document.querySelector("#settingsSave").style.backgroundColor = "#ccc";
    document.querySelector("#settingsSave").style.color = "#808080";
    document.querySelector("#settingsSave").disabled = true;
  }
  const delete_account=()=>{
    // user want to delete account
    if(document.cookie!=""){
      if (window.confirm("Vous souhaitez nous quitter ? :c")) {
        axios.post("https://apivivide.leanguyen.fr/supprimer.php",JSON.stringify({token:token}), {
          headers: {
            'Content-Type': 'application/json'
          }
        })
        .then((res)=>console.log(res.data));
        console.log(token);
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      } else {
        alert("Content de vous voir ici ! ^^")
      }
    }else{
      alert("Connectez-vous")
    }
  }
  return (
    <div className="settings">
      <Helmet>
        <title>Mes paramètres</title>
        <link rel="canonical" href="https://vivide.leanguyen.fr/settings" />
      </Helmet>
      <section>
        <div className="profile_settings">
          <h1>Profil</h1>
          <p> Informations personelles</p>
          <div>
            <section className="settings_input">
              <span>
                <label htmlFor="first_name"> Nom d'utilisateur </label>
                <input
                  type="text"
                  name="name"
                  placeholder={placeholder.pseudo}
                  onChange={change}
                  id="inputName"
                />
              </span>
              <span>
                <label htmlFor="email"> Mail </label>
                <input
                  type="text"
                  name="email"
                  placeholder={placeholder.email}
                  onChange={change}
                  id="inputEmail"
                />
              </span>
            </section>
          </div>
        </div>

        {/* <div className="aesthetic">
          <h1>Apparence</h1>
          <div className="checkbox"> */}
            {/* <div className="checkbox" onClick={switchColors}> */}
            {/* <input type="checkbox" id="switch" />
            <label htmlFor="switch"></label>
            <p>Mode sombre/clair</p>
          </div>
        </div> */}

        <div className="delete_account">
          <button>
            <RiDeleteBin6Line size="25px" className="icone_menu" onClick={delete_account}/>
            <p> Supprimer le compte </p>
          </button>
        </div>
      </section>
      <div className="save_settings">
        <button className="button_delete" onClick={reset}>
          {" "}
          Annuler{" "}
        </button>
        <button className="button_modify" id="settingsSave" onClick={request}>
          {" "}
          Enregistrer{" "}
        </button>
      </div>
      <section className="conditions">
        <h1>Conditions</h1>
        <a href="https://vivide.leanguyen.fr/mentions/mentionslegales.html">
          <p>Mentions légales</p>
        </a>
        <a href="https://vivide.leanguyen.fr/mentions/politique.html">
          <p>Polique de confidentialité</p>
        </a>
        <a href="https://vivide.leanguyen.fr/landing-page.php">
          <p>Qu'est-ce-que Vivide?</p>
        </a>
      </section>
    </div>
  );
}

export default Settings;
