import {
  faCheckCircle,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { checkout as checkoutApi } from "../../../../api";
import "../styles.css";
import { useRef } from "react";
import { ToastContainer, toast } from "react-toastify";

const PERKS_DEMO = [
  { text: "Qui culpa non. Aliquid rerun Ullarm nulla." },
  {
    text: "Vel distinction aliquam. Lusto quo itaque sit ullam cum placeat qui nihill.",
  },
  { text: "Qui culpa nan. Aliquid id rerun." },
  { text: "Qui culpa non. Aliquid rerum. Ullarn nulla." },
  {
    text: "Non eius quo rerum veritatis quis aut sed aeas. East adipisci vera harum.",
  },
  { text: "Ut libera soluta. Vera et consequuntur." },
];

const ProductCards = ({ product }) => {
  const purchaseRef = useRef(null);
  const getCheckoutLink = async () => {	
    if (product.price == 0){
      toast.success("Working on your product!", {
        style: {width: "400px", margin: "auto"},
        position: "top-center",
        autoClose: 4000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
      });
    }
    const res = await checkoutApi(product.id, localStorage.getItem("business_token"));
    if(res.data.status == "success") {
      window.location.href = res.data.checkout_link;
    } else {
      toast.error(res.data.message, {
        style: {width: "200px", margin: "auto"},
        position: "top-center",
        autoClose: 4000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
      });
    }
    purchaseRef.current.disabled = "";
  }
  const onPurchase = () => {
    purchaseRef.current.disabled = "disabled";
    getCheckoutLink();
  }

  return (
    <div className="col-12 col-md-12 col-lg-3 p-3">
      <div className="product-card">
        <div className="px-3 w-100 position-relative">
          <div className="d-flex justify-content-between">
            <div className="my-1">
              <h5 className="text-white my-1" style={{ fontWeight: "650" }}>
                {product.name}
              </h5>
              <h6 
                className="text-white" 
                style={{ 
                  paddingTop: "15px", 
                  marginTop: "-14px"
                }}
              >
                {product.channel_type}
              </h6>
            </div>
            <div style={{
              marginTop: "-14px"
            }}>
              <div
                className="mb-3"
                style={{
                  padding: "10px 24px",
                  marginTop: "20px",
                  backgroundColor: "#00878C",
                  borderRadius: "6px",
                }}
              >
                <h4
                  className="text-center m-0 d-flex align-self-center text-white"
                  style={{ fontWeight: "650", lineHeight: "28px" }}
                >
                  {`$${product.price}`}
                </h4>
                <h6
                  className="text-center m-0 text-white"
                  style={{ fontWeight: "lighter" }}
                >
                  /month
                </h6>
              </div>
            </div>
          </div>
          <hr style={{ color: "#333844", height: "3px" }} />
          <div className="mt-4 d-flex">
              <h6 className="text-white description" style={{ fontWeight: "350" }}>
                {product.description}
              </h6>
            </div>
          {/* {PERKS_DEMO.map((perks, idx) => (
            <div key={idx} className="mt-4 d-flex">
              <FontAwesomeIcon
                style={{
                  backgroundColor: "white",
                  borderRadius: "30px",
                }}
                color="#00878C"
                icon={faCheckCircle}
                size="lg"
              />
              <h6 className="ms-3 text-white" style={{ fontWeight: "350" }}>
                {perks.text}
              </h6>
            </div>
          ))} */}
          <div className="d-flex justify-content-center"
           
           style={{    
            position: 'absolute', 
            width: '93%',
            bottom: '0'
          }}>
            <button
              onClick={onPurchase}
              ref={purchaseRef}
              style={{
                borderRadius: "10px",
                height: "45px",
                backgroundColor: "transparent",
                border: "1px solid #00878C",
                width: "100%",
                fontWeight: "600",
                color: "white",
              }}
            >
{product.price != 0 ? product.trial !== null && product.trial_period > 0 ? "Free Trial" : "Purchase" : "Free"}
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductCards;
