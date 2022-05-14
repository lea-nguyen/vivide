import React, { Fragment } from "react";
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";

import "../styles/general.css";
import "../styles/header.css";
import "../styles/menu.css";
import "../styles/projects.css";
import "../styles/settings.css";
import "../styles/articles.css";

import Home from "../HomeComponents/Home";
import Settings from "../Other/Settings";
import Article from "../Articles/Article.js";
import WatchVideo from "../Videos/WatchVideo";
import TrendProjects from "../Projects/TrendProjects";
import { ArticlesList } from "../Articles/ArticlesList";
import Project from "../Projects/Project";
import Header from "../Components/Header";
import Playlists from "../Other/Playlists";
import AllProjects from "../Projects/AllProjects";
import Menu from "../Components/Menu";
import Results from "../Projects/Results";
import SavedProjects from "../Projects/SavedProjects";
import ProjectsHistory from "../Projects/ProjectsHistory";
import LikedProjects from "../Projects/LikedProjects";

class All extends React.Component {
  render() {
    return (
      <Router>
        <Fragment>
          <div className="body_container">
            <Menu />
            <Header />
            <div className="main">
              <Switch>
                {/* add landing page */}
                <Route exact path="/" component={Home} />
                <Route exact path="/articles" component={ArticlesList} />
                <Route
                  exact
                  path="/articles/:article_url"
                  component={Article}
                />
                <Route exact path="/parametres" component={Settings} />
                <Route
                  exact
                  path="/parcours/tous"
                  component={() => <AllProjects title={"Parcours"} />}
                />
                <Route
                  exact
                  path="/parcours/mesparcours"
                  component={() => (
                    <SavedProjects class={"projects"} classclass={"project"} />
                  )}
                />
                <Route exact path="/playlists" component={Playlists} />
                <Route
                  exact
                  path="/playlists/historique-parcours"
                  component={ProjectsHistory}
                />
                <Route
                  exact
                  path="/playlists/videos-aimees"
                  component={LikedProjects}
                />
                <Route
                  exact
                  path="/parcours/:project_url"
                  component={Project}
                />
                <Route
                  exact
                  path="/parcours/:project_url/v/:video_url"
                  component={WatchVideo}
                />
                <Route exact path="/query/:filter" component={Results} />
              </Switch>
            </div>
          </div>
        </Fragment>
      </Router>
    );
  }
}

export default All;
