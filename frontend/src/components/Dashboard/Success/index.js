import "./Success.css";
import { useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import logo from "../../../assets/logo.png";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faDiscord } from "@fortawesome/free-brands-svg-icons";

const SuccessPage = () => {
  const { id } = useParams();
  const [ invoice, setInvoice ] = useState([]);
  const [ isEmpty, setEmpty ] = useState(false);
  const [ isFetch, setFetch ] = useState(true);

  useEffect(()=>{
    // invoiceApi(id).then(invoiceResponse => {
    //   setInvoice(invoiceResponse.data);
    //   setFetch(true);
    //   if(invoiceResponse.data.length == 0) {
    //     setEmpty(true);
    //   }
    // })
  }, []);
  
  return (
    <div 
      style={{
        
          height: "100vh",
        backgroundColor: "#171a23",
      }}
    >
      <div className="h-100">
        {
          isEmpty? 
          <>
            <p style={{color: "white"}}>{`Not found`}</p>
          </> 
          :
          isFetch && <>
            <div className="w-100 h-100">
              <div className="d-flex h-100">
                <div className="success-right-side">
                    <div className="success-icon">
                        <img src={logo} alt="logo" />
                    </div>
                    <h1 className="success-title">Thank you for purchasing!</h1>
                    <p className="success-description">Your service has been automatically set up in your server. Click "Continue" below to set up your custom branding. For support, please open a ticket in the Mocean Client Server.</p>
                    <div style={{marginTop: "4%"}}>
                        <a href={ (id != null ) ? `/manage/${id}` : "/home" } className="success-button-primary">Continue</a>
                    </div>
                    <div style={{marginTop: "10%"}}>
                        <a href="https://discord.com/invite/mocean" className="client-link">
                          <FontAwesomeIcon icon={faDiscord} className="mr-4" />&nbsp;	&nbsp;Join the Mocean Client Server</a>
                    </div>
                </div>
              </div>
            </div>
          </>
        }
      </div>
    </div>
  );
};

export default SuccessPage;
