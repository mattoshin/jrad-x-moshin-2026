import {
  faArrowDown19,
  faBoxesStacked,
  faSearch,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useState, useEffect } from "react";
import ProductCards from "./ActiveProductCards/ActiveProductCard";
import {activeProducts as activeProductsApi} from "../../../api";
import "./styles.css";


const Products = () => {
  const [search, setSearch] = useState("");
  const [prodcuts, setProducts] = useState([]);

  useEffect(()=>{
    const getData = async () => {
      const productsResponse = await activeProductsApi();
      setProducts(productsResponse.data);
    };
    getData();
  }, []);

  return (
    <div className="p-5 mt-2">
      <div
        className="d-flex justify-content-between"
        style={{ height: "50px" }}
      >
        <div className="my-auto">
          <h5 className="text-white my-auto">Active Products</h5>
        </div>
        <div className="d-flex right-side-products">
          <div
            style={{
              height: "100%",
              width: "250px",
              backgroundColor: "#1E222B",
              borderRadius: "4px",
              display: "flex",
            }}
          >
            <FontAwesomeIcon
              className="my-auto ms-2"
              color="white"
              icon={faSearch}
              size="sm"
            />
            <input
              className="input-products"
              type="text"
              placeholder="Search"
              onChange={(e) => {
                setSearch(e.target.value);
              }}
              value={search}
              style={{
                height: "100%",
                width: "100%",
                outline: "none",
                backgroundColor: "#1E222B",
                paddingLeft: "15px",
                border: "none",
                color: "red !important",
              }}
            />
          </div>

          
        </div>
      </div>
      <hr className="mb-3" style={{ height: "2px", color: "#1E222B" }} />
      <div
        className="ps-3 pe-3"
        style={{
          marginTop: "20px",
          position: "sticky",
          top: 0,
          zIndex: "1000 !important",
        }}
      >
        <div className="row">
          <div
          
            className="custom-table-cols-active product-col col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3"
          >
            <h6 className="text-white">
              Product
            </h6>
          </div>

          <div className="custom-table-cols-active progress-col col-3 d-none d-md-block">
            <h6 className="text-white">Product Type</h6>
          </div>
          <div className="custom-table-cols-active progress-col col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3">
            <h6 className="text-white">
              Amount
            </h6>
          </div>

          <div className="custom-table-cols-active status-col col-4 col-xs-4 col-sm-4 col-md-3 col-lg-3 col-xl-3 px-3 px-lg-2 ">
            <h6 className="text-white">
              Days Remaining
            </h6>
          </div>
        </div>
      </div>
      <div className="mt-2">

      { 
        search?
        prodcuts.filter(data => data.name.toLowerCase().includes(search.toLowerCase())).map((product, idx) => (
          <ProductCards key={idx} product={product} />
        ))
        :
        prodcuts.map((product, idx) => (
          <ProductCards key={idx} product={product} />
        ))}
      </div>
    </div>
  );
};
export default Products;
