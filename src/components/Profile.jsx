import React from "react";
import axios from "axios";
import Logo from "./Logo";
import { Link,useNavigate } from "react-router-dom";
import authHeader from "../assets/header/auth-header";
import REACT_APP_API_URL from "../assets/header/env";
function Profile() {
  const Navigate = useNavigate();
  async function handleLogout() {
    try{
      const res = await axios.get(`${REACT_APP_API_URL}/log-out`,{ headers: authHeader() });
    if(res){
      console.log(res);
      sessionStorage.removeItem('user');
      Navigate("/");
      
    }
    }catch(e){
      console.log(e);
    }
  }
  return (
    <div className="col-sm-9 my-auto col-md-7 col-lg-5 mx-auto">
      <div className="card border-0 shadow pt-4 rounded-3 ">
        <div className=" p-4 p-sm-5">
          <Logo />
          <div className="d-grid mt-5">
            <Link
              to="/one-day-trip"
              className="border border-2 border-warning mt-4 fw-bold  text-dark  btn btn-outline-warning"
            >
              One Day Trip
            </Link>
            <Link
              to="/taxi-trip"
              className="border border-2 border-warning mt-3 fw-bold  text-dark  btn btn-outline-warning"
            >
              Normal Taxi
            </Link>
            <Link
              to="/local-trip"
              className="border border-2 border-warning mt-3 fw-bold  text-dark  btn btn-outline-warning"
            >
              Local Trip
            </Link>
            <Link
              to="/hills-trip"
              className="border border-2 border-warning mt-3 fw-bold  text-dark  btn btn-outline-warning"
            >
              Hills Trip
            </Link>
            <button onClick={handleLogout} className="border border-2 border-warning mt-3 fw-bold  text-light  btn btn-warning">Log Out</button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Profile;
