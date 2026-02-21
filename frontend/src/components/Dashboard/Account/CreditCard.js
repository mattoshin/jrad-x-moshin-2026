import { faCcVisa } from "@fortawesome/free-brands-svg-icons";
import { faCreditCard } from "@fortawesome/free-regular-svg-icons";
import { faCreditCardAlt, faEllipsis } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import logo from "../../../assets/logo.png";
import chip from "../../../assets/chip.png";

const CreditCard = ({ creditCards, setSelectedCard, selectedCard }) => {
  return (
    <div className="main-wrapper-down p-3 position-relative">
      <div
        className="position-relative m-auto card"
        style={{
          overflow: "clip",
        }}
      >
        <h3 className="logo">
          <img src={logo} width={60} height={60} alt="logo" />
        </h3>
        
        <img src={chip} width={30} height={30} className="chip" alt="chip" />
        <h3 className="number">**** **** **** {selectedCard.lastFour}</h3>
        <h5 className="card-holder">
          <span>card holder</span><br />
          {selectedCard.name}
        </h5>
        <h5 className="valid"><span>expiry date</span><br />{selectedCard.expiration}</h5>
        <div
          style={{
            position: "absolute",
            left: -60,
            bottom: -100,
            height: "200px",
            width: "200px",
            filter: "opacity(5%)",
            borderRadius: "150px",
            backgroundColor: "white",
          }}
        />
        <div
          style={{
            position: "absolute",
            right: -60,
            top: -100,
            height: "200px",
            width: "200px",
            filter: "opacity(4%)",
            borderRadius: "150px",
            backgroundColor: "white",
          }}
        />
      </div>
    </div>
  );
};
export default CreditCard;
