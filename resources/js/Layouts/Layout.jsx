import React from "react";
import { Link, useForm } from "@inertiajs/react";

export default function Layout({ children }) {
    const { post } = useForm();

    const handleLogout = (e) => {
        e.preventDefault();
        post(route("logout"));
    };

    return (
        <div>
                <Link href={route("dashboard")}>Dashboard</Link>
                <Link href={route("wallet.index")}>Wallet</Link>
                <Link href={route("admin.dashboard")}>Admin Dashboard</Link>
                <a href="#" onClick={handleLogout}>
                    Logout
                </a>
            <main>{children}</main>
        </div>
    );
}
