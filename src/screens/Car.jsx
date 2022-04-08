import axios from "axios";
import { useEffect, useState } from "react";

import CarCard from "../components/carCard";
import REACT_APP_API_URL from "../assets/header/env";
import { useLocation, Outlet} from "react-router";
import authHeader from "../assets/header/auth-header";

const Car = () => {
    let location = useLocation();
    const [cars, setCars] = useState([]);

    

    useEffect( () => {

        async function getCars()
        {
        const res = await axios.get(`${REACT_APP_API_URL}/cars-list`,{ headers: authHeader() });
        if (res) {
            setCars(res.data.data);
        }
       
        }

        getCars() 

    }, [])


    return (
        <><Outlet></Outlet>
         {location.pathname === "/dashboard/car" &&(
            <div className="container">
                <div className="row" id="ads">
                {
                    cars && cars.length > 0 ? 
                    
                    cars.map((car,i)=>(
                        <CarCard key={i} data={car} id ={i+1} />
                    )):"Loding ..."
                    

                }
     
                </div>
            </div>)}

        </>
    )
}

export default Car;