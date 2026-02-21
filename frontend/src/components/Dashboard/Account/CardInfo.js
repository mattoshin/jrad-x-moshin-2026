import { faEllipsis } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useState } from "react";
import CreditCard from "./CreditCard";

const CardInfo = () => {
  const [creditCards, setCreditCards] = useState([
    {
      id: 0,
      name: "Test Name",
      expiration: "01/01",
      lastFour: "0101",
    },
    { id: 1, name: "Test Name 2", expiration: "02/02", lastFour: "0202" },
  ]);

  const [selectedCard, setSelectedCard] = useState(creditCards[0]);

  return (
    <div className="main-cards-wrapper col-md-12 col-lg-4 p-3">
      <div className="main-card">
        <div className="main-wrapper-up">
          <h5 className="text-white align-items-center d-flex h-100">
            Payment Information
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
