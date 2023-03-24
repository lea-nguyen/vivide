import React from "react";
import { NavLink } from "react-router-dom";
import img from "../images/icon.png";
import { MdHomeFilled, MdOutlineArticle, MdPlaylistPlay } from "react-icons/md";
import { BiBookmarks } from "react-icons/bi";
import { FiChevronDown, FiChevronUp } from "react-icons/fi";
import { AiOutlineSetting } from "react-icons/ai";
import { SiDiscord } from "react-icons/si";

class Menu extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      visibility: false,
    };
    this.toggleAccordion = this.toggleAccordion.bind(this);
    this.showMenu = this.showMenu.bind(this);
    this.closeNav = this.closeNav.bind(this);
    this.activate = this.activate.bind(this);
    this.slideBack = this.slideBack.bind(this);
  }

  componentDidMount() {
    // manage menu
    let url = window.location.href;
    let domain = "https://vivide.leanguyen.fr";
    // let domain = "http://localhost:3000";
    domain = domain.length;
    url = url.substring(domain);
    if (url.length > 1) {
      document.querySelector(".disactivate").classList.remove("isActiveLevel1");
    }
  }

  toggleAccordion() {
    // manage Mes Parcours from menu
    this.setState((state) => ({
      visibility: !state.visibility,
    }));
  }
  closeNav(e) {
    // close Mes Parcours from menu
    this.setState({
      visibility: false,
    });
    document.querySelector("body").style.overflowY = "auto";
    // manage the class disactivate of menu
    document.querySelector(".a").classList.remove("isActiveLevel1");
    if (e.target.classList.contains("disactivate") === false) {
      document.querySelector(".disactivate").classList.remove("isActiveLevel1");
    } else {
      document.querySelector(".disactivate").classList.add("isActiveLevel1");
    }
  }
  showMenu() {
    // when you open menu for screen < 701px
    this.setState((state) => ({
      visibility: !state.visibility,
    }));
    document.querySelector("body").style.overflowY = "hidden";
  }
  activate() {
    // when you open menu
    document.querySelector(".a").classList.add("isActiveLevel1");
    document.querySelector(".disactivate").classList.remove("isActiveLevel1");
  }
  slideBack() {
    // when you open menu for screen < 701px
    document.querySelector("body").style.overflowY = "auto";
    document.querySelector(".menu").style.display = "none";
  }
  render() {
    if (this.state.visibility) {
      // Mes Parcours is open
      return (
        <div className="menu_contain">
          <div className="menu menu_open">
            <div className="outside" onClick={this.slideBack}></div>
            <img src={img} alt="" />
            <nav>
              <NavLink
                to="/"
                onClick={this.closeNav}
                className="disactivate"
                activeClassName="isActiveLevel1"
              >
                <MdHomeFilled className="icone_menu" size="25px" /> Accueil{" "}
              </NavLink>
              <p onClick={this.toggleAccordion} className="a isActiveLevel3">
                <BiBookmarks className="icone_menu" size="25px" />
                Mes Parcours
                <FiChevronUp className="icone_fleche" size="20px" />
              </p>
              <ul className="accordion_close">
                <li>
                  <NavLink
                    to="/parcours/tous"
                    activeClassName="isActiveLevel2"
                    onClick={this.activate}
                  >
                    Tous les parcours
                  </NavLink>
                </li>
                <li>
                  <NavLink
                    to="/parcours/mesparcours"
                    activeClassName="isActiveLevel2"
                    onClick={this.activate}
                  >
                    Mes parcours
                  </NavLink>
                </li>
              </ul>
              <NavLink
                to="/playlists"
                onClick={this.closeNav}
                activeClassName="isActiveLevel1"
              >
                <MdPlaylistPlay className="icone_menu" size="25px" /> Playlists{" "}
              </NavLink>
              <NavLink
                to="/articles"
                onClick={this.closeNav}
                activeClassName="isActiveLevel1"
                className="menu_article"
              >
                <MdOutlineArticle className="icone_menu" size="25px" /> Articles{" "}
              </NavLink>
              <NavLink
                to="/parametres"
                onClick={this.closeNav}
                activeClassName="isActiveLevel1"
              >
                <AiOutlineSetting className="icone_menu" size="25px" />{" "}
                Paramètres{" "}
              </NavLink>
            </nav>
            <div className="social_link social_discord">
              <a
                href="https://discord.gg/U83pP7asgA"
                target="_blank"
                rel="noreferrer"
                className="discord"
              >
                <SiDiscord className="discord" size="25px" />
              </a>
              Discord
            </div>
          </div>
            
        </div>
      );
    } else {
      // Mes Parcours is closed
      return (
        <div className="menu_contain ">
          <div className="menu">
            <div className="outside" onClick={this.slideBack}></div>
            <img src={img} alt="" />
            <nav>
              <NavLink
                to="/"
                onClick={this.closeNav}
                className="disactivate"
                activeClassName="isActiveLevel1"
              >
                <MdHomeFilled className="icone_menu" size="25px" /> Accueil
              </NavLink>
              <h3 onClick={this.toggleAccordion} className="a">
                <BiBookmarks className="icone_menu" size="25px" />
                Mes Parcours
                <FiChevronDown className="icone_fleche" size="20px" />
              </h3>
              <NavLink
                to="/playlists"
                onClick={this.closeNav}
                activeClassName="isActiveLevel1"
              >
                <MdPlaylistPlay className="icone_menu" size="25px" /> Playlists
              </NavLink>
              <NavLink
                to="/articles"
                onClick={this.closeNav}
                activeClassName="isActiveLevel1"
                className="menu_article"
              >
                <MdOutlineArticle className="icone_menu" size="25px" /> Articles
              </NavLink>
              <NavLink
                to="/parametres"
                onClick={this.closeNav}
                activeClassName="isActiveLevel1"
              >
                <AiOutlineSetting className="icone_menu" size="25px" />{" "}
                Paramètres
              </NavLink>
            </nav>
            <div className="social_link social_discord">
              <a
                href="https://discord.gg/U83pP7asgA"
                target="_blank"
                rel="noreferrer"
                className="discord"
              >
                <SiDiscord className="discord" size="25px" />
              </a>
              Discord
            </div>
          </div>
        </div>
      );
    }
  }
}

export default Menu;
