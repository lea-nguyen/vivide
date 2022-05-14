import React from 'react';
import Filter from '../Components/Filter';
import PreviewProject from './PreviewProject';
import Projects from './Projects';
import {Helmet} from 'react-helmet';

class AllProjects extends Projects {

    constructor(props){
        super(props);
        this.state = {
            type : '0',
            data : [],
            projects:[]
        };
        this.handleChange = this.handleChange.bind(this);
    }
    render() {
        return (
            <div>
                <Helmet>
                    <title>Tous les parcours</title>
                    <link rel="canonical" href="https://vivide.app/parcours/tous" />
                    <meta name="description" content='Retrouvez toutes les informations sur nos projets et nos tutoriels vidéos' />
                </Helmet>
                <h1>{this.props.title}</h1>
                <Filter filters={["Tous","Audiovisuel","Design","Développement"]} handleChange={this.handleChange} />
                <div className={this.props.class}>
                    {this.state.projects.map((project) => (
                        <PreviewProject data={project} popup={this.popup} class="project" key={project.id_project} />
                    ))}
                </div>
            </div>
        )
    }
}

export default AllProjects;