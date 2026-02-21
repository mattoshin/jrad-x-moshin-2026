import { faEllipsis } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useRef, useState, useEffect } from "react";
import {
  portalApi as portalApi
} from "../../../../api";
import { ToastContainer, toast } from "react-toastify";
import CreditCard from "./CreditCard";

const CardInfo = () => {
  const portalRef = useRef(null);
  const [creditCards, setCreditCards] = useState([
    {
      id: 0,
      name: "Test Name",
      expiration: "04/24",
      lastFour: "4242",
    },
    { id: 1, name: "Test Name 2", expiration: "02/02", lastFour: "0202" },
  ]);

  const [selectedCard, setSelectedCard] = useState(creditCards[0]);

  const getPortalLink = async () => {
    const res = await portalApi(localStorage.getItem("business_token"));
    
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
    portalRef.current.disabled = "";
  }
  const onPortal = () => {
    portalRef.current.disabled = "disabled";
    getPortalLink();
  }

  return (
    <div 
      className="main-cards-wrapper col-md-12 col-lg-4 p-3"
      onClick={onPortal}
      ref={portalRef}
      aria-hidden="true"
    >
      <div className="main-card">
        <div className="main-wrapper-up">
          <h5 className="text-white align-items-center d-flex h-100">
            Manage Payments
          </h5>
        </div>
        <CreditCard
          selectedCard={selectedCard}
          setSelectedCard={setSelectedCard}
          creditCards={creditCards}
        />
      </div>
    </div>
  );
};
export default CardInfo;
