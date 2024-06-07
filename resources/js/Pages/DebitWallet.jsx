// resources/js/Pages/DebitWallet.jsx
import React from "react";
import { useForm } from "@inertiajs/react";
import { Link, Head } from "@inertiajs/react";
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";

export default function DebitWallet() {
    const { data, setData, post, processing, errors } = useForm({
        amount: "",
    });

    const handleDebit = (e) => {
        e.preventDefault();
        post(route("wallet.debit"), { onSuccess: () => setData("amount", "") });
    };

    return (
        <GuestLayout>
            <Head title="Debit Wallet" />
            <h2>Credit Wallet</h2>
            <form onSubmit={handleDebit}>
                <div>
                    <InputLabel
                        htmlFor="Amount to Debit"
                        value="Amount to Debit"
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
                    Debit
                </PrimaryButton>
            </form>
            <Link href={route("dashboard")} className="btn btn-secondary">
                Back to Dashboard
            </Link>
        </GuestLayout>
    );
}
