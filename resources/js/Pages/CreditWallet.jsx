// resources/js/Pages/CreditWallet.jsx
import React from "react";
import { useForm } from "@inertiajs/react";
import { Link, Head } from "@inertiajs/react";
import GuestLayout from "@/Layouts/GuestLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";

export default function CreditWallet() {
    const { data, setData, post, processing, errors } = useForm({
        amount: "",
    });

    const handleCredit = (e) => {
        e.preventDefault();
        post(route("wallet.credit"), { onSuccess: () => setData("amount", "") });
    };

    return (
        <GuestLayout>
            <Head title="Credit Wallet" />
            <h2>Credit Wallet</h2>
            <form onSubmit={handleCredit}>
                <div>
                    <InputLabel
                        htmlFor="Amount to Credit"
                        value="Amount to Credit"
                    />
                    <TextInput
                        id="amount"
                        type="number"
                        value={data.amount}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("amount", e.target.value)}
                    />
                    <InputError message={errors.amount} className="mt-2" />
                </div>
                <PrimaryButton className="ms-4" disabled={processing}>
                    Credit
                </PrimaryButton>
            </form>
            <Link href={route("dashboard")} className="btn btn-secondary">
                Back to Dashboard
            </Link>
        </GuestLayout>
    );
}
