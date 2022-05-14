import React from 'react';
import WatchedProjects from './WatchedProjects';
import {Helmet} from "react-helmet";

class LikedProjects extends React.Component {
    render() {
        return (
            <main className="home">
                <Helmet>
                    <title>Mes vidéos aimées</title>
                    <link rel="canonical" href="https://vivide.app/playlists/videos-aimees" />
                </Helmet>
                <h1>Mes vidéos aimées</h1>
                <WatchedProjects class="projects" classclass='project'/>
            </main>
        )

        
    }
}

export default LikedProjects;