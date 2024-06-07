import React from "react";
import { Head, Link } from "@inertiajs/react";

export default function Reports({ transactions }) {
    return (
        <div>
            <Head title="Transaction Reports" />
            <h2>Transaction Reports</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    {transactions.map((transaction) => (
                        <tr key={transaction.date}>
                            <td>{transaction.date}</td>
                            <td>${transaction.total.toFixed(2)}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <div>
                <Link
                    href={route("admin.reports")}
                    className="btn btn-primary"
                >
                    View Report
                </Link>
                <Link
                    href={route("admin.exportPDF")}
                    className="btn btn-primary"
                >
                    Export as PDF
                </Link>
                <Link
                    href={route("admin.exportCSV")}
                    className="btn btn-primary"
                >
                    Export as Excel
                </Link>
            </div>
        </div>
    );
}
