import React, { useEffect } from 'react';

class Filter extends React.Component {
    constructor(props){
        super(props)
    }
    render(){
        return (
            <div className="projects">
                <form action="" className="buttons_filter">
                    {this.props.filters.map((filter) => (
                        <input className="button_filter" onClick={this.props.handleChange} id={this.props.filters.indexOf(filter)} key={this.props.filters.indexOf(filter)} type="button" value={filter}/>
                    ))}
                </form>
            </div>
        )
    }
}

export default Filter;