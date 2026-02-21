import "./Cancel.css";
import { useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import logo from "../../../assets/logo.png";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faDiscord } from "@fortawesome/free-brands-svg-icons";
import { 
  getPlan as getPlanApi
} from "../../../api";

const CancelPage = () => {
  const { id } = useParams();
  const [productInfo, setProductInfo] = useState({
    productName: "NFT Monitors",
    lastPayment: "",
    endDate: "",
  });
  const [ paidProduct, setPaidProduct ] = useState(false);
  const [ isFetch, setFetch ] = useState(true);


  const getData = async () => {
    const planRes = await getPlanApi(id);
    setProductInfo({
      ...productInfo,
      'productName': planRes.data.plan_name,
      'lastPayment': planRes.data.last_payment,
      'endDate': planRes.data.end_date,
    });
    setPaidProduct(planRes.data.paidProduct);
  };

  useEffect(()=>{
    if(id){
      getData();
    }
  }, [id]);
  
  return (
    <div 
      style={{
        
          height: "100vh",
        backgroundColor: "#171a23",
      }}
    >
      <div className="h-100">
        {
          paidProduct? 
          <>
            <div className="w-100 h-100">
              <div className="d-flex h-100">
                <div className="success-right-side">
                    <div className="success-icon">
                        <img src={logo} alt="logo" />
                    </div>
                    <h1 className="success-title">We’re sorry to see you go.</h1>
                    <p className="success-description">We hope you have enjoyed using {productInfo.productName} and we are incredibly grateful for your business. Your most recent payment was on {productInfo.lastPayment} so you will have access to {productInfo.productName} until {productInfo.endDate}. If you have any issues with your subscription or any suggestions on how we can make Mocean better for you, please open a ticket in our server Discord below. If you decide that you want to add {productInfo.productName} back to your server in the future, you can purchase through the Product Store tab.</p>
                    <div style={{marginTop: "4%"}}>
                        <a href={`/active-products`} className="success-button-primary">Got It</a>
                    </div>
                    <div style={{marginTop: "10%"}}>
                        <a href="https://discord.com/invite/mocean" className="client-link">
                          <FontAwesomeIcon icon={faDiscord} className="mr-4" />&nbsp;	&nbsp;Join the Mocean Client Server</a>
                    </div>
                </div>
              </div>
            </div>
          </>
          :
          isFetch && <>
            <div className="w-100 h-100">
              <div className="d-flex h-100">
                <div className="success-right-side">
                    <div className="success-icon">
                        <img src={logo} alt="logo" />
                    </div>
                    <h1 className="success-title">We’re sorry to see you go.</h1>
                    <p className="success-description">We hope you enjoyed using {productInfo.productName} and we are incredibly grateful for your business. If you have any questions or suggestions on how we can make Mocean better for you, please open a ticket in our Discord server below. If you decide that you want to add this {productInfo.productName} back to your server in the future, you can do so through the Product Store tab.</p>
                    <div style={{marginTop: "4%"}}>
                        <a href={`/active-products`} className="success-button-primary">Got It</a>
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

export default CancelPage;
