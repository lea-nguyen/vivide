import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import Filter from '../Components/Filter';
import PreviewVideo from '../Videos/PreviewVideo';
import PreviewProject from './PreviewProject';
import {Helmet} from 'react-helmet';

const Results = () => {
    const { filter } = useParams();
    let filtered = filter.toLowerCase();
    const [projects, setProjects] = useState([]);
    const [videos, setVideos] = useState([]);
    let resP = [];
    let resV = [];
    useEffect(() => {
    // get all projects filtered with query research
      axios.get(`https://apivivide.leanguyen.fr/playlists.php?`)
            .then((response) => {
                response.data.forEach(project => {
                    if(project.name_project.toLowerCase().includes(filtered) || project.description.toLowerCase().includes(filtered)){
                        resP.push(project)
                    };                   
                });
            })
            .then(() => {setProjects(resP)})
    // get all video filtered with query research
      axios.get(`https://apivivide.leanguyen.fr//playlist.php?`)
            .then((response) => {
                console.log();
                response.data.forEach(video => {
                    if(video.name_video.toLowerCase().includes(filtered) || video.description.toLowerCase().includes(filtered)){
                        resV.push(video)
                    };                   
                });
            })
          .then(() => {setVideos(resV)})
    },[filter])
  
    return (
        <div className="results">
            <Helmet>
                <title>{filter}</title>
                <link rel="canonical" href={`https://vivide.leanguyen.fr/query/${filter}`} />
                <meta name="description" content={`Retrouvez toutes les informations sur nos projets et nos tutoriels vidéos correspondants à votre recherche ${filter}`} />
            </Helmet>
            <Filter filters={["Tous","Audiovisuel","Design","Développement"]}/>
            {projects.map((playlist) => (
                <PreviewProject data={playlist} class="project" key={playlist.id_project} />
            ))}
            {videos.map((video) => (
                <PreviewVideo video={video} key={video.id_video} />
            ))}
        </div>
      )
  }

export default Results;