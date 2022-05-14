import React from 'react';

class SignUp extends React.Component {
    constructor(props){
        super(props);
        this.handleEmail = this.handleEmail.bind(this);
        this.handlePwd = this.handlePwd.bind(this);
        this.handleUsrname = this.handleUsrname.bind(this);
    }
    
    handleEmail (event) {
        this.setState({
            email : event.target.value
        })
    }
    handlePwd (event) {
        this.setState({
            pwd : event.target.value
        })
    }
    handleUsrname (event) {
        this.setState({
            username : event.target.value
        })
    }
}
export default SignUp;