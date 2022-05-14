import axios from "axios";
import React, { useEffect, useState } from 'react';
import {FiThumbsUp} from 'react-icons/fi'
import {IoMdThumbsUp} from 'react-icons/io'

function LikeButton(props){
    
    const [button, setButtonContent] = useState(true);

    const buttonStyle = {
        backgroundColor: "rgba(0,0,0,0)",
        border: "rgba(0,0,0,0)",
    }

    useEffect(()=>{
        
        if(props.liked){
            // video is liked
            setButtonContent(true)
        }else{
            // video is not liked
            setButtonContent(false)
        }

    },[props.video_url,props.project_url,props.token,props.liked])

    const swithLike=()=>{
        if(document.cookie!=""){
            let data = {
                token : props.token,
                video : props.video_url,
                project : props.project_url,
                do : true
            }
            
            // validate token befor access someone's data aka yours only
            axios.post("https://api.vivide.app/validatejwt.php",JSON.stringify(data), {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then((res)=>{
                if(res.data!=""){
                    if(res.data.token!=props.token){
                        props.changeCookie(res.data.token)
                    }
                }
                // be able to un/like
                axios.post("https://api.vivide.app/add_like.php",JSON.stringify(data), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then((response)=>{
                        if(response.data==0){
                            setButtonContent(true)
                        }else{
                            setButtonContent(false)
                        }
                    });
            })

        }else{
            alert("Connectez-vous pour pouvoir aimer cette vidéo.");
        }
    }
    if(button){
        // if is liked
        return <button style= { buttonStyle } onClick={swithLike}><FiThumbsUp size="30px" color="white"/></button>
    }else{
        return <button style= { buttonStyle } onClick={swithLike}><IoMdThumbsUp size="30px" color="white"/></button>
    }
    
}

export default LikeButton;