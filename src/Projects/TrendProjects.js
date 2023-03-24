import React from "react";
import Filter from "../Components/Filter";
import Projects from "./Projects";
import PreviewProject from "./PreviewProject";

class TrendProjects extends Projects {
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

export default TrendProjects;
