import { BusinessCard } from "./BusinessCards/BusinessCard";
import axios from "axios";
import { useEffect, useState } from "react";
const SwitchBusiness = () => {
  const [businesses, setBusinesess] = useState([]);
  const [errorCheck, setError] = useState(false);

  useEffect(() => {
    let token = localStorage.getItem("token");
    const getData = async () => {
      try{
        const guildsResponse = await axios.get(
          "https://admin.mocean.info/guilds",
          {
            headers: { Authorization: `Bearer ${token}` },
          }
        );
        setBusinesess(guildsResponse.data);
      } catch {
        setError(true);
      }
    };

    getData();
  }, []);
  function ErrorPage() {
    return (<h1
    style={{
      color: "white",
      textAlign: "center",
      marginTop: "40px"
    }}>
        Error finding your guilds, try to relogin and make sure you have authorized our application!</h1>);
  }
  
  function ListBusinesses() {
    return (<div className="d-flex row px-5 justify-content-between">
    {businesses.map((business, idx) => (
      <BusinessCard key={idx} business={business} />
    ))}
    </div>);
  }
  return (
    <>
      <div
        className="col-12 p-3 h-0"
        style={{ height: "10px !important", marginTop: "5%" }}
      >
        <div className="main-wrapper-up">
          <h5 className="text-white ms-3 align-items-center d-flex h-100">
            Select a Business
          </h5>
        </div>
      </div>
      <div className="d-flex row px-5 justify-content-between">
        {errorCheck
          ? <ErrorPage/>
          : <ListBusinesses/>
        }
      </div>
    </>
  );
};

export default SwitchBusiness;
