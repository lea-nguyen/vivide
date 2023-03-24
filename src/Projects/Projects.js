import React from 'react';
import axios from 'axios';


class Projects extends React.Component {
    constructor(props){
        super(props);
        this.state = {
            data : [],
            projects : []
        };
        this.handleChange = this.handleChange.bind(this);
    }
    componentDidMount(){
        // get all projects
        axios.get(`https://apivivide.leanguyen.fr/playlists.php?`)
            .then((response) => this.setState({ data: response.data,projects : response.data})
        );
        // initiate the filter on first button
        document.querySelector('.button_filter').classList.add("is_filter")
    }

    handleChange(event) {
        // handle change filter
        const filtersList = document.querySelectorAll('.button_filter');
        filtersList.forEach((filter)=>{
            filter.classList.remove('is_filter');
        })
        event.target.classList.add("is_filter");
        // filter project
        if (event.target.getAttribute('id')!=0){
            this.setState({projects : this.state.data.filter(project => project.tag === event.target.getAttribute('id'))})
        }else{
            this.setState({projects: this.state.data})
        }
    }

}

export default Projects;