import React from "react";
import { parseJwt } from "rs-jwt";
import { FiChevronDown, FiChevronUp } from "react-icons/fi";
import { BiSearch, BiLogOut, BiLogIn } from "react-icons/bi";

class ProfileInfo extends React.Component {
  constructor(props) {
    super(props);
    this.logout = this.logout.bind(this);
  }
  logout() {
    /*FROM https://www.w3schools.com/js/js_cookies.asp, the 25/02/2022 at 15:47*/
    document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }
  render() {
    // if is connected
    return (
      <p className="profil_info">
        <a onClick={this.logout} href="">
          <BiLogOut className="icone_menu" size="25px" />
          Se déconnecter
        </a>
      </p>
    );
  }
}

class ProfilePicture extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      visibility: false,
      hasCookie: false,
      username: "",
      letter: "?",
    };
    this.toggleInfo = this.toggleInfo.bind(this);
  }
  componentDidMount() {
    // if has cookie aka is connected
    if (document.cookie != "") {
      // get the cookie
      /*FROM https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/
      const name = "token=";
      const cDecoded = decodeURIComponent(document.cookie); //to be careful
      const cArr = cDecoded.split("; ");
      let res;
      cArr.forEach((val) => {
        if (val.indexOf(name) == 0) {
          res = val.substring(name.length);
        }
      });
      /*END OF https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/

      // get payload of token as cookie
      const result = parseJwt(res);
      const payload = result.getPayload();
      this.setState({
        username: payload.username,
        letter: payload.username.substring(0, 1),
      });
    }
  }

  toggleInfo() {
    this.setState((state) => ({
      visibility: !state.visibility,
    }));

    /*FROM https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/
    const name = "token=";
    const cDecoded = decodeURIComponent(document.cookie); //to be careful
    const cArr = cDecoded.split("; ");
    let res;
    cArr.forEach((val) => {
      if (val.indexOf(name) === 0) {
        res = val.substring(name.length);
        this.setState({
          hasCookie: true,
        });
      }
    });
    /*END OF https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/
    return;
  }

  render() {
    if(document.cookie){
      if (this.state.visibility) {
        return (
          <span className="contain_profile">
            <div className="profile" onClick={this.toggleInfo}>
              <p>{this.state.letter}</p>
              <FiChevronUp className="icone" />
            </div>
            <ProfileInfo
              hasCookie={this.state.hasCookie}
              username={this.state.username}
            />
          </span>
        );
      } else {
        return (
          <span className="contain_profile">
            <div className="profile" onClick={this.toggleInfo}>
              <p>{this.state.letter}</p>
              <FiChevronDown className="icone" />
            </div>
          </span>
        );
      }
    }else{
      return(
        <div className="not_log_profile">
          <a className="inscrire" href="https://vivide.leanguyen.fr/identification/inscription" target="_blank">S'inscrire</a>
          <a className="se_connecter" href="https://vivide.leanguyen.fr/identification/connexion" target="_blank">Se connecter</a>
        </div>
      )
    }
  }
}

class Search extends React.Component {
  constructor() {
    super();
    this.enter = this.enter.bind(this);
  }
  // submit query research
  enter(event) {
    event.preventDefault();
    if(event.type=="onclick" || event.key=="Enter"){
      let filter = document.querySelector(".champ").value;
      window.location.href = "https://vivide.leanguyen.fr/query/" + filter;
    }
  }
  render() {
    return (
      <div className="search_header">
        <BiSearch className="icone_search" size="20px" onClick={this.enter} />
        <input
          className="champ"
          type="text"
          onKeyUp={this.enter}
          placeholder="Rechercher..."
        />
      </div>
    );
  }
}

class Header extends React.Component {
  constructor() {
    super();
    this.open = this.open.bind(this);
  }

  // click to open the menu for when screen < 701px
  open() {
    document.querySelector(".menu").style.display = "block";
    document.querySelector(".menu").style.animation = "slide 0.3s";
    document.querySelector(".menu_contain").style.display = "block";
    document.querySelector(".menu_contain").style.animation = "slide 0.3s";
  }

  render() {
    return (
      <div className="header">
        <div className="header_contain">
          {/* click to open the menu for when screen < 701px */}
          <div className="button" onClick={this.open}>
            <div className="line"></div>
            <div className="line"></div>
            <div className="line"></div>
          </div>
          <Search />
          <ProfilePicture />
        </div>
      </div>
    );
  }
}

export default Header;
