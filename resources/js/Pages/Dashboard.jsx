import React from "react";
import { Head, Link } from "@inertiajs/react";

export default function Dashboard() {
    return (
        <div>
            <Head title="Dashboard" />
            <h2>Dashboard</h2>
            <p>Welcome to your dashboard!</p>
            <Link href={route("wallet.index")}>Go to Wallet</Link>
        </div>
    );
}
