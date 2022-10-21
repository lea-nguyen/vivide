import React from 'react';
import WatchedProjects from './WatchedProjects';
import {Helmet} from "react-helmet";

class ProjectsHistory extends React.Component {
    render() {
        return (
            <main className="home">
                <Helmet>
                    <title>Historique des parcours</title>
                    <link rel="canonical" href="https://vivide.leanguyen.fr/playlists/historique-parcours" />
                    <meta name="description" content={`Vivide est une plateforme ayant pour objectif de diffuser des contenus vidéos type tutoriel de quelques minutes pour les utilisateurs qui souhaitent acquérir de nouvelles compétences dans divers domaines du multimédia. (design, développement, communication et audiovisuel).`} />
                </Helmet>
                <h1>Historique des parcours</h1>
                <WatchedProjects class="projects" number={50} classclass='project'/>
            </main>
        )

        
    }
}

export default ProjectsHistory;