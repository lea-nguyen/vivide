import React from 'react';
import {BsTwitter} from 'react-icons/bs'
import {AiFillLinkedin,AiFillInstagram} from 'react-icons/ai'

class SocialMedia extends React.Component {
    render() {
        return (
            <div className="social_medias">
                <h1>Réseaux sociaux</h1>
                <p>Abonnez-vous !</p>
                <div className="social_link">
                    <div><a href="https://twitter.com/VivideApp" target="_blank" rel='noreferrer'><BsTwitter size="20px" color="white"/></a></div>
                    <div><a href="https://www.instagram.com/vivide.app/" target="_blank" rel='noreferrer'><AiFillLinkedin size="25px" color="white"/></a></div>
                    <div><a href="https://www.linkedin.com/company/76204665" target="_blank" rel='noreferrer'><AiFillInstagram size="25px" color="white"/></a></div>
                </div>
            </div>
        )
    }
}

export default SocialMedia;