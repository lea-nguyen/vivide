import axios from 'axios';
import React, { useEffect, useState } from 'react';
import PreviewVideo from './PreviewVideo';

const VideosPlaylist = (props) => {
    const [dataVideo, setDataVideo] = useState([]);
    // get the videos of project
    useEffect(() => {
        axios.get(`https://apivivide.leanguyen.fr//playlist.php?`)
            .then((response) => {
                let videos = response.data.filter(video => video.project_url == props.project_url);
                setDataVideo(videos);
            });
    }, [props]);

    return (
        <div className='playlist'>
            {dataVideo.map((video) => (
                <PreviewVideo video={video} proj={props.project_url} key={video.id_video} />
            ))}
        </div>
    );
}

export default VideosPlaylist;