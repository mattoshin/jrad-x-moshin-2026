import {
  faArrowDown19,
  faBoxesStacked,
  faSearch,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useEffect, useState } from "react";
import ProductCards from "./ProductCards/productCards";
import "./styles.css";
import {products as productsApi} from "../../../api";

const Products = () => {
  const [search, setSearch] = useState("");
  const [prodcuts, setProducts] = useState([]);

  useEffect(()=>{
    const getData = async () => {
      const productsResponse = await productsApi();
      if(productsResponse.data) {
        setProducts(productsResponse.data);
      } else {
        setProducts([]);
      }
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
          <h5 className="text-white my-auto">Product Store</h5>
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

          {/* <div
            className="dropdown ms-3 d-flex"
            style={{
              height: "100%",
              width: "150px",
            }}
          >
            <button
              className="btn w-100 h-100 align-items-center justify-self-center d-flex justify-content-between mx-auto my-auto btn-secondary dropdown-button dropdown-toggle"
              type="button"
              id="dropdownMenuButton"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Sort by
            </button>
            <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a className="dropdown-item" href="#">
                Action
              </a>
              <a className="dropdown-item" href="#">
                Another action
              </a>
              <a className="dropdown-item" href="#">
                Something else here
              </a>
            </div>
          </div> */}
          {/* <div
            style={{
              padding: "4px",
              height: "100%",
              width: "150px",
              marginLeft: "13px",
              backgroundColor: "#1E222B",
              borderRadius: "4px",
              display: "flex",
              justifyContent: "space-around",
            }}
          >
            <h6 className="text-white my-auto" style={{ fontWeight: "450" }}>
              Collection type
            </h6>
            <FontAwesomeIcon
              className="my-auto ms-2"
              color="white"
              icon={faBoxesStacked}
              size="sm"
            />
          </div> */}

          {/* <div
            data-toggle="dropdown"
            style={{
              padding: "4px",
              height: "100%",
              width: "150px",
              marginLeft: "13px",
              backgroundColor: "#1E222B",
              borderRadius: "4px",
              display: "flex",
              justifyContent: "space-around",
            }}
          >
            <h6 className="text-white my-auto" style={{ fontWeight: "450" }}>
              Price Range
            </h6>
            <FontAwesomeIcon
              className="my-auto ms-2"
              color="white"
              icon={faArrowDown19}
              size="sm"
            />
          </div> */}
        </div>
      </div>
      <hr className="mb-3" style={{ height: "2px", color: "#1E222B" }} />
      <div className="row">
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
