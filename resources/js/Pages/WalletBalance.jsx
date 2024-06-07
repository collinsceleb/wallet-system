import React from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import { Link, Head } from "@inertiajs/react";

export default function WalletBalance({ wallet }) {
    return (
        <GuestLayout>
            <h2>Wallet Balance</h2>
            <p>
                Current Balance: $
                {wallet && wallet.balance != null
                    ? wallet.balance.toFixed(2)
                    : "0.00"}
            </p>
            <Link href={route("wallet.index")} className="btn btn-secondary">
                Back to Wallet
            </Link>
        </GuestLayout>
    );
}
