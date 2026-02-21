import { AmountDue } from "./AmountDue";
import { ClientDetails } from "./ClientDetails";
import { InvoiceDetailAction } from "./InvoiceDetailActions";
import { InvoiceMonitorDetails } from "./InvoiceMonitorDetails";
import "./InvoiceDetails.css";
import { useParams } from "react-router-dom";
import { invoice as invoiceApi } from "../../../../api";
import { useState, useEffect } from "react";

const InvoiceDetail = () => {
  const { id } = useParams();
  const [ invoice, setInvoice ] = useState([]);
  const [ isEmpty, setEmpty ] = useState(false);
  const [ isFetch, setFetch ] = useState(false);

  useEffect(()=>{
    invoiceApi(id).then(invoiceResponse => {
      setInvoice(invoiceResponse.data);
      setFetch(true);
      if(invoiceResponse.data.length == 0) {
        setEmpty(true);
      }
    })
  }, []);
  
  return (
    <div className="p-5">
      <div className="row invoice-details">
        {
          isEmpty? 
          <>
            <p style={{color: "white"}}>{`Not found`}</p>
          </> 
          :
          isFetch && <>
            <div className="col-12 col-xl-8 h-100 my-3">
              <InvoiceMonitorDetails invoice={invoice[0]}/>
            </div>
            <div className="col-12  col-xl-4 row h-100 my-3">
              <ClientDetails invoice={invoice[0]}/>
              <AmountDue invoice={invoice[0]}/>
              <InvoiceDetailAction />
            </div>
          </>
        }
      </div>
    </div>
  );
};

export default InvoiceDetail;
