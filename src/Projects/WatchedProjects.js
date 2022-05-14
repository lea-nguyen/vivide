import axios from 'axios';
import React, { useEffect, useState } from 'react';
import PreviewVideo from '../Videos/PreviewVideo';
import PreviewProject from './PreviewProject';
 

const WatchedProjects = (props) => {

    const [data, setData] = useState([{
        description : 'OOPS... Veuillez vous connecter pour accéder à vos derniers projets',
        name_admin : '',
        thumbnail_proj: ''
    },{
        description : 'OOPS... Veuillez vous connecter pour accéder à vos derniers projets',
        name_admin : '',
        thumbnail_proj: ''
    },{
        description : 'OOPS... Veuillez vous connecter pour accéder à vos derniers projets',
        name_admin : '',
        thumbnail_proj: ''
    }]);

    

    useEffect(() => {

        let postData = {};
        
        /*FROM https://www.w3schools.com/js/js_cookies.asp, the 25/02/2022 at 15:47*/
        if(document.cookie!=""){
            const name = "token=";
            const cDecoded = decodeURIComponent(document.cookie); //to be careful
            const cArr = cDecoded.split('; ');
            let token ="";
            cArr.forEach(val => {
                if (val.indexOf(name) === 0){
                    token = val.substring(name.length)
                    postData={
                        token : token,
                        number :  props.number
                    }
                }
            })
            /*END OF https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/
            
            // validate token before accessing someone's informations aka you only
            axios.post("https://api.vivide.app/validatejwt.php",JSON.stringify(postData), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then((res)=>{
                    if(res.data!=""){
                        
                        if(res.data.token!=token){
                            if(cArr.length>3){
                                // the user checked the remember button
                                document.cookie = "token="+res.data.token+cArr[1]+cArr[2]+cArr[3]
                            }else{
                                // the user did not check the remember button
                                document.cookie = "token="+res.data.token+cArr[1]+cArr[2]+cArr[3]
                            }
                        }
                        if(props.number!=undefined){
                            // project from history
                            axios.post("https://api.vivide.app/history.php",JSON.stringify(postData), {
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then((res) => {
                                if(res.data.length>0 && document.cookie!=""){
                                    setData(res.data)
                                }
                            })
                            
                        }else{
                            //liked video
                            axios.post("https://api.vivide.app/like.php",JSON.stringify(postData), {
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then((res) => {
                                if(res.data.length>0 && document.cookie!=""){
                                    setData(res.data)
                                }
                            });
                        }
                    }
                })
            }
        

    }, []);
    if(props.number!=undefined){
        return (
            <div className={props.class}>
                {data.map((project) => (
                    <PreviewProject data={project} class={props.classclass} key={project.id_project} />
                ))}
            </div>
        );
    }else{
        return (
            <div className={props.class}>
                {data.map((project) => (
                    <PreviewVideo video={project} class={props.classclass} key={project.id_project} />
                ))}
            </div>
        );
    }
}
export default WatchedProjects;