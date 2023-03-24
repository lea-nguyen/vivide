import ReactDOM from "react-dom";
import React, { Fragment } from "react";
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";
import { Helmet } from "react-helmet";
import All from "./App/All";
import Register from "./Registration/Register";

class App extends React.Component {
  /* componentDidMount(){
    let has_seen = localStorage.getItem('vivide_landing_page');
    if(!has_seen){
        window.location.href = "https://vivide.leanguyen.fr/landing-page.php";
    }
    if(document.cookie.includes('undefined')){
        document.cookie="token=; expires=Sun, 20 Aug 2000 12:00:00 UTC"
    }
  } */

    render() {
        return (
            <Router>
            <Fragment>
                <Helmet>
                    <html lang="fr"></html>
                    <title>Apprends avec vivide</title>
                    <link rel="canonical" href="https://vivide.leanguyen.fr/" />
                    <meta name="keywords" content="tutoriel, créer, projet, site web, vidéo, montage, maquette, html, css, coder, bases" />
                    <meta name="description" content="Vivide est une plateforme ayant pour objectif de diffuser des contenus vidéos type tutoriel de quelques minutes pour les utilisateurs qui souhaitent acquérir de nouvelles compétences dans divers domaines du multimédia. (design, développement, communication et audiovisuel)." />
                    <meta name="revised" content="27/03/2022" />
                    <meta name="og:title" content="Apprends avec vivide "/>
                    <meta name="og:description" content="Vivide est une plateforme ayant pour objectif de diffuser des contenus vidéos type tutoriel de quelques minutes pour les utilisateurs qui souhaitent acquérir de nouvelles compétences dans divers domaines du multimédia. (design, développement, communication et audiovisuel)."/>
                    <meta name="og:image" content="src/images/icon_o.png"/>
                    <meta property="og:site_name" content="vivide.leanguyen.fr"/>
                    <meta property="twitter:card" content="summary"/>
                </Helmet>
                <Switch>
                    <Route path="/identification" component={Register} />
                    <Route path="/" component={All} />
                </Switch>
            </Fragment>
            </Router>
            
        )
    }
}

export default App;
ReactDOM.render(<App />, document.getElementById("root"));
