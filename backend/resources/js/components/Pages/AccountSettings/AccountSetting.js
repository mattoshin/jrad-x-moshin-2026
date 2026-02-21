import React, {useEffect, useState, Component} from "react";
import Cookies from 'universal-cookie';
import axios from 'axios';
import toast, { Toaster } from 'react-hot-toast';
import ReactDOM from 'react-dom'


class AccountSetting extends Component{
    constructor(props){
    super(props);
    this.state={
        id:'',
        user:'',
        name:'',
        planD: {
            twitter: '',
            email: '',
            name: '',
        },
        owner:'',
        email:'',
        twitter:'',

    }
    this.handleSubmit = this.handleSubmit.bind(this)
    //this.state= this.state.bind(this)
}

UNSAFE_componentWillMount=e=>{
        const cookies = new Cookies();
        let users = cookies.get('user')
        let userL = users
        if (!users.user.api_token){
            window.location.href= '/logout';
        }
        this.setState({
           owner:userL.user.id
        })
        
    }
    componentDidMount(e){
        const cookies = new Cookies();
                let users = cookies.get('user')
        let userL = users.user.id
        axios.get('http://localhost:8000/api/owner/'+ userL)
        .then(res=>{
            let planD= {        
                ...this.state.planD,  
                twitter : res.data.twitter == null ? '' : res.data.twitter,
                email : res.data.email == null ? '' :  res.data.email ,
                name : res.data.name == null ? '' :  res.data.name   
            }
            this.setState({
                planD: planD
            })
            this.setState({
                owner:userL.user.id
             })
    })}

    handleNameChange = (e, currData) => {
        
        e.preventDefault();
        let planD= {        
                ...this.state.planD,   
                twitter : currData.twitter,
                email : currData.email,
                name : e.target.value.trim() == "" ? null : e.target.value
            }
            this.setState({
                planD: planD
            })        
     }

     handleTwitterChange = (e, currData) => {
            
               
        let planD= {        
             ...this.state.planD,   
             twitter : e.target.value,
             email : currData.email,
             name : currData.name
         }
         this.setState({
             planD: planD
         })
         
    }
    handleEmailChange = (e, currData) => {
            
               
        let planD= {        
             ...this.state.planD,
             twitter : currData.twitter,
             email : e.target.value,
             name : currData.name
         }
         this.setState({
             planD: planD
         })
         
    }
         
 
    handleSubmit(e){
      e.preventDefault();
      let emails= this.state.planD.email
      let emailValidator= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if(emails.match(emailValidator)){
          const all= {
              name:this.state.planD.name,
              owner:this.state.owner,
               email:this.state.planD.email,
              twitter:this.state.planD.twitter,
   
          }
          
           axios.post('http://localhost:8000/api/businesses',{...all})
           .then(res=>toast("You've successfully updated your business details"))
           .catch(err=>toast("There has been an error, please contact an admin"))

      }else{

          toast('Not A Valid Email')
      }

    }
    render(){
        const {render} =this.props
        const {owner}=this.state
    return(

            <div id="accountSetting">
                <div class="row">
                    <div class="col-xl-5 col-sm-12">
                        <div id="accountSettings" class="text-white ">
                            <div class="">
                                <h6 id="monitorSettings" class ="">Account Settings</h6>
                            </div>
                            <div>
                                <form onSubmit={this.handleSubmit} class="monitorForm ms-1" >
                                    <div  /* id="manageMonitorSettingsInput"*/>
                                                <label  id="inputBoxAccount"/* class="block mx-1 my-1 ml-5"*/>
                                                    <span>Company Name</span>
                                                    <input id="inputBox" type="text" required={true} onChange={(e) => this.handleNameChange(e, this.state.planD)} value={this.state.planD.name} class="mt-1 py-2 placeholder-white text-white" name="name" /*onChange={this.handleChange} value={this.state.companyName}*/ placeholder="Example"></input>
                                                </label>
                                                <label  id="inputBoxAccount"/* class="block mx-1 my-1 ml-5"*/>
                                                    <span>Company Email</span>
                                                    <input id="inputBox" required={true} type="email" onChange={(e) => this.handleEmailChange(e, this.state.planD)} value={this.state.planD.email} class="mt-1 py-2 placeholder-white text-white" name="email" /*onChange={this.handleChange} value={this.state.companyName}*/ placeholder="example@mocean.info"></input>
                                                </label>
                                                <label  id="inputBoxAccount"/* class="block mx-1 my-1 ml-5"*/>
                                                    <span>Twitter</span>
                                                    <input id="inputBox"required={true} type="text" onChange={(e) => this.handleTwitterChange(e, this.state.planD)} value={this.state.planD.twitter} class="mt-1 py-2 placeholder-white text-white" name="twitter" /*onChange={this.handleChange} value={this.state.companyName}*/ placeholder="@Twitter"></input>
                                                    <input type='hidden'  value={owner} onInput={(e)=>this.setState({
                                                        owner:e.target.value
                                                    })} ></input>
                                                </label>
                                        <button id="SubmitButtonMonitorSettings"/*id="saveSettingsMonitor" */ /*onSubmit={this.handleSubmit}*/ class="text-white mt-3 mb-4  py-2 col-3 col-sm-4 col-md-3 row-md" value="Save Changes" >Save</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <Toaster/>
            </div>



        );
}
}

if(document.getElementById('accountSettings')){
    ReactDOM.render(<AccountSetting/>,document.getElementById('accountSettings'))
}

export default AccountSetting;
