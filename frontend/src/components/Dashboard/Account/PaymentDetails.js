import React, {useState} from 'react'
import CreditCard from "./CreditCard";

export const PaymentDetails = () => {
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
  return (
    <div>
      <h5 
        className="text-white" 
        style={{
          fontSize: "22px",
          fontWeight: "600"
        }}
      >Payment Details</h5> 
      <p 
        className="mb-4"
        style={{
          color: "#acacac"
        }}
      >Change default payment method</p>
      <div className='d-flex'>
        <CreditCard
          selectedCard={selectedCard}
          setSelectedCard={setSelectedCard}
          creditCards={creditCards}
        />
      </div>
    </div>
  )
}