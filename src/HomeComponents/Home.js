import React, {Fragment} from 'react';
import WatchedProjects from '../Projects/WatchedProjects';
import TrendProjects from '../Projects/TrendProjects';
import RightMenu from './RightMenu';
import {Helmet} from 'react-helmet';
class Home extends React.Component {
    render() {
        
            return (
                <Fragment>
                <Helmet>
                    <title>Accueil</title>
                    <link rel="canonical" href="https://vivide.app/" />
                    <meta name="description" content={`Vivide est une plateforme ayant pour objectif de diffuser des contenus vidéos type tutoriel de quelques minutes pour les utilisateurs qui souhaitent acquérir de nouvelles compétences dans divers domaines du multimédia. (design, développement, communication et audiovisuel). `} />
                </Helmet>
                <main className="home">
                    <h1>Mes parcours</h1>
                    <WatchedProjects class="on_going_projects" number={3} classclass='on_going_project'/>
                    <TrendProjects title="Tendances" class="trend" trend={1}/>
                </main>
                <RightMenu />
                </Fragment>
            )

        
    }
}

export default Home;