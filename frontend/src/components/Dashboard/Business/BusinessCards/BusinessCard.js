
import React from "react";
import Popout from 'react-popout'
import { useNavigate, Navigate } from "react-router-dom";
import logo from "../../../../assets/logo.png";
import { 
  businessCreate as businessCreateApi,
  guilds as guildsApi,
  activeProducts as activeProductsApi,
} from "../../../../api";

export const BusinessCard = ({ business }) => {
  const nav = useNavigate();
  const [isPoppedOut, setPoppedOut] = React.useState(false);
  
  const productCheckAndRedirect = () => { 

    const getData = async () => {
      const productsResponse = await activeProductsApi();
      if(productsResponse.data.length != 0){
        nav("/home");
      } else {
        nav("/products");
      }
    };
    getData();
  }


  const login = () => {
    const getData = async () => {
      const res = await guildsApi();
      res.data.map((data, index)=>{
        if(data.id === business.id){
          localStorage.setItem("business_token", business.token);
          productCheckAndRedirect();
          // nav("/home");
        }
      })
    };
    getData();
  }

  const setup = () => {
    setPoppedOut(false);
    const getData = async () => {
      const res = await businessCreateApi(business.id);
      if(res.data.status == "error") {
        if(!isPoppedOut) {
          setPoppedOut(true);
        }
      }
    };
    getData();
  }

  return (
    <>
      {isPoppedOut ? 
        <Popout 
          url={`https://discord.com/oauth2/authorize?scope=bot+applications.commands&response_type=code&client_id=${process.env.REACT_APP_DISCORD_CLIENT_ID}&permissions=8&guild_id=${business.id}&redirect_uri=${process.env.REACT_APP_DISCORD_BOT_INVITE_REDIRECT_URL}`}
          title='Window title'
          options={{height: "1200px", width: "500px", left: "0px"}} 
          onClosing={()=>{
            let businessToken = localStorage.getItem("business_token");
            if(businessToken) {
              nav("/home");
            }
            setPoppedOut(false);
          }}
        >
        </Popout>
      :
      <></>}
      <div
        className="row mb-2 pe-4 py-4 py-2 col-sm-12 col-md-6 col-xl-4"
        style={{
          borderRadius: "6px",
          height: "fit-content",
          backgroundColor: "#1E222B",
        }}
      >
        <div
          className="col-4 col-lg-3 d-flex col  justify-content-center"
          style={{ overflowX: "overlay" }}
        >
          <div style={{ height: "60px" }}>
            <img
              style={{ borderRadius: "40px" }}
              height="60"
              width="60"
              src={business.icon ? "https://cdn.discordapp.com/icons/" + business.id + "/" + business.icon + ".png" : logo }
            />
          </div>
        </div>

        <div
          className="col-6 "
          style={{
            overflowX: "overlay",
            color: "#fff",
            height: "100% !important",
          }}
        >
          <h6
          style={{ 
            fontWeight: "bold",
          }}>{business.name}</h6>
          <p className="m-0 p-0">{business.owner ? "Owner" : "Admin" }</p>
        </div>
        <div
          className="col-2 d-flex align-items-center justify-content-center m-0 p-0"
          style={{ overflowX: "overlay" }}
        >
          {business.token ? <a
            style={{
              backgroundColor: "#00878C",
              color: "#eee",
              display: "flex",
              justifyContent: "center",
              alignItems: "center",
              cursor: "pointer"
            }}
            className="active-sub-button"
            onClick={login}
          >
            Login
          </a> : <a
            style={{
              backgroundColor: "#2F3541",
              color: "#eee",
              display: "flex",
              justifyContent: "center",
              alignItems: "center",
              cursor: "pointer"
            }}
            className="active-sub-button"
            onClick={setup}
          >
            Setup
          </a> 
          }
        </div>
      </div>
    </>
  );
};
