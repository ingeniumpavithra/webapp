import axios from "axios";
import React from "react";
import authHeader from "../assets/header/auth-header";
import REACT_APP_API_URL from "../assets/header/env";
import { useNavigate } from "react-router";
import { useEffect, useState } from "react";
import { ReportBase } from "istanbul-lib-report";

const Admin = () => {
    let Navigate = useNavigate();
    const [report, setReport] = useState('');
    const [total_days, setTotalDays] = useState(0);
    const [total, setTotal] = useState(0);
    useEffect(() => {

        async function getReport() {
            try {
                const res = await axios.get(`${REACT_APP_API_URL}/get-report`, { headers: authHeader() });
                if (res) {
                    const r_data = res.data;
                
                    setReport(r_data);
                }
            } catch (e) {
                console.log(e);
            }
        }
        getReport()

    }, [])

    useEffect(() => {
        /**
         * whenever report changes the total days and total will change
         */
        if (report) {
            let totalDays = 0;
            let fTotal = 0;
            totalDays =parseInt( report.one_day[0].days  ? report.one_day[0].days: 0) +parseInt(report.taxi[0].days ? report.taxi[0].days:0)  
            + parseInt(report.local[0].days ? report.local[0].days : 0) + parseInt( report.hills[0].day ?  report.hills[0].days: 0)
            fTotal = parseInt( report.one_day[0].total  ? report.one_day[0].total: 0) 
            +parseInt(report.taxi[0].total ? report.taxi[0].total:0)  
            + parseInt(report.local[0].total ? report.local[0].total : 0) 
            + parseInt( report.hills[0].total ?  report.hills[0].total: 0)
         
            setTotalDays(totalDays);
            setTotal(fTotal);
        }
    }, [report])


console.log(report);
    const navigateToTable = () => {
        Navigate("/dashboard/car");
    };

    return (
        <div className="flex-grow-1">
            <h3 className="text-center p-3" style={{ color: "#e6de08", backgroundColor: "Black" }} >Welcome to SRI VETRI TAXI</h3>
            <div className="container">
                <div className="row" id="ads">
                    <div className="col-md-3 col-sm-6  col-lg-3 my-3 cars" onClick={navigateToTable}>
                        <div className="card rounded">
                            <div className="card-body text-center">
                                <div className="ad-title m-auto">
                                    <h5>Total Cars</h5>
                                    <h2>8</h2>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div className="col-md-3 col-sm-6  col-lg-3 my-3">
                        <div className="card rounded">
                            <div className="card-body text-center">
                                <div className="ad-title m-auto">
                                    <h5>Income last 30 days</h5>
                                    <h2>{report && total_days}</h2>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div className="col-md-3 col-sm-6  col-lg-3 my-3">
                        <div className="card rounded">
                            <div className="card-body text-center">
                                <div className="ad-title m-auto">
                                    <h5>Total Income</h5>

                                    <h2>
                                        {total}</h2>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <h3>Last 30 days Income</h3>
                <div className="row" id="ads">
                    <div className="col-md-3 col-sm-6  col-lg-3 my-3">
                        <div className="card rounded">
                            <div className="card-body text-center">
                                <div className="ad-title m-auto">
                                    <h5>One Day Trip</h5>
                                    <h2>{report && report.one_day[0].days}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="col-md-3 col-sm-6  col-lg-3 my-3">
                        <div className="card rounded">
                            <div className="card-body text-center">
                                <div className="ad-title m-auto">
                                    <h5>Normal Taxi Trip</h5>
                                    <h2>{report && report.taxi[0].days}</h2>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div className="col-md-3 col-sm-6  col-lg-3 my-3">
                        <div className="card rounded">
                            <div className="card-body text-center">
                                <div className="ad-title m-auto">
                                    <h5>Local Trip</h5>
                                    <h2>{report && report.local[0].days}</h2>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div className="col-md-3 col-sm-6  col-lg-3 my-3">
                        <div className="card rounded">
                            <div className="card-body text-center">
                                <div className="ad-title m-auto">
                                    <h5>Hills Trip</h5>
                                    <h2>{report && report.hills[0].days}</h2>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    );
};
export default Admin;