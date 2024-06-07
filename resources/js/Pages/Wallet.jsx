import React, { useEffect, useState} from "react";
import { Link, Head } from "@inertiajs/react";
import WalletBalance from "./WalletBalance";import GuestLayout from "@/Layouts/GuestLayout";

export default function Wallet({ wallet, updateBalance }) {
    const [balance, setBalance] = useState(0);

    useEffect(() => {
        if (wallet) {
            setBalance(wallet.balance);
        }
    }, [wallet]);

    const handleUpdateBalance = (type, amount) => {
        updateBalance(type, amount);
        setBalance(
            (prevBalance) =>
                prevBalance + (type === "credit" ? amount : -amount)
        );
    };
    return (
        <GuestLayout>
            <Head title="Wallet" />
            <WalletBalance balance={balance} />
            <div>
                <Link
                    href={route("wallet.credit")}
                    className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    onClick={() => handleUpdateBalance("credit", amount)}
                >
                    Credit Wallet
                </Link>
                <Link
                    href={route("wallet.debit")}
                    className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    onClick={() => handleUpdateBalance("debit", amount)}
                >
                    Debit Wallet
                </Link>
            </div>
        </GuestLayout>
    );
}
