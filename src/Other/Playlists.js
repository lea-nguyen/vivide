import { NavLink } from "react-router-dom";
import React from "react";
import BackButton from "../Components/BackButton";
import WatchedProjects from "../Projects/WatchedProjects";
import { Helmet } from "react-helmet";

class Playlists extends React.Component {
  render() {
    return (
      <div className="history">
        <Helmet>
          <title>Apprends avec vivide</title>
          <link rel="canonical" href="https://vivide.app/playlists" />
        </Helmet>
        <BackButton linkBack={"../"} />
        <h2>Historique des parcours</h2>
        <WatchedProjects
          class="on_going_projects"
          number={6}
          classclass="on_going_project"
        />
        <NavLink to="/playlists/historique-parcours">
          <h3>
            <p className="btn">Voir plus</p>
          </h3>
        </NavLink>

        <h2>Vidéos aimées</h2>
        <NavLink to="/playlists/videos-aimees"></NavLink>
        <NavLink to="/playlists/videos-aimees">
          <h3>
            <p className="btn">Voir plus</p>
          </h3>
        </NavLink>
      </div>
    );
  }
}
export default Playlists;
