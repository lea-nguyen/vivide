import axios from 'axios';
import React, { useEffect, useState } from 'react';
import PreviewProject from './PreviewProject';
import {Helmet} from 'react-helmet'; 

const SavedProjects = (props) => {
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

    /*FROM https://www.w3schools.com/js/js_cookies.asp, the 25/02/2022 at 15:47*/
    const name = "token=";
    const cDecoded = decodeURIComponent(document.cookie); //to be careful
    const cArr = cDecoded.split('; ');
    let token = "";
    let postData={};
    cArr.forEach(val => {
        if (val.indexOf(name) === 0){
            token = val.substring(name.length)
            postData={
                token : val.substring(name.length),
            }
        }
    })
    /*END OF https://www.tabnine.com/academy/javascript/how-to-get-cookies/, the 24/02/2022 at 02:24*/

    useEffect(() => {
        if(document.cookie!=""){
            // validate token before accessing someone's informations aka you only
            axios.post("https://apivivide.leanguyen.fr/validatejwt.php",JSON.stringify(postData), {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then((res)=>{
                if(res.data.token!=""){
                    if(res.data.token!=token){
                        if(cArr.length>3){
                            // the user checked the remember button
                            document.cookie = "token="+res.data.token+cArr[1]+cArr[2]+cArr[3]
                        }else{
                            // the user did not check the remember button
                            document.cookie = "token="+res.data.token+cArr[1]+cArr[2]+cArr[3]
                        }
                    }
                    // get saved projects of user
                    axios.post("https://apivivide.leanguyen.fr/my_projects.php",JSON.stringify(postData), {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then((res) => {
                            console.log(res.data)
                        if(res.data.length>0){
                            setData(res.data);
                        }else{
                            setData([{
                                description : '',
                                name_admin : '',
                                thumbnail_proj: ''
                            },{
                                description : '',
                                name_admin : '',
                                thumbnail_proj: ''
                            },{
                                description : '',
                                name_admin : '',
                                thumbnail_proj: ''
                            }]);
                        }
                    });
                }
            });
        
        }
    }, []);
    
    if(document.cookie && data[0].name_admin!=""){
        return (
            <div className={props.class}>
                <Helmet>
                    <title>Mes parcours sauvegardés</title>
                    <link rel="canonical" href="https://vivide.leanguyen.fr/parcours/mesparcours" />
                </Helmet>
                <h1>Mes parcours enregistrés</h1>
                {data.map((project) => (
                    <PreviewProject data={project} class={props.classclass} key={project.id_project} />
                ))}
            </div>
        );
    }else{
        return (
            <div className={props.class}>
                <Helmet>
                    <title>Mes parcours sauvegardés</title>
                    <link rel="canonical" href="https://vivide.leanguyen.fr/parcours/mesparcours" />
                </Helmet>
                <h1>Mes parcours enregistrés</h1>
                {data.map((project) => (
                    <PreviewProject data={project} class="bland_project" key={project.id_project} />
                ))}
            </div>
        );
    }
    
}
export default SavedProjects;