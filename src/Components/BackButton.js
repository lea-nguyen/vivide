import React from 'react';
import { NavLink } from 'react-router-dom';
import {ImArrowLeft} from 'react-icons/im'

const BackButton = (props) => {
    return <NavLink to={props.linkBack} className="back_button"><ImArrowLeft className="icone_menu"/> Retour</NavLink>
}

export default BackButton;