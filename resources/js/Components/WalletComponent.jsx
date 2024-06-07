import React, { useState } from "react";
function WalletComponent() {
    const [balance, setBalance] = useState(0);

    const updateBalance = (type, amount) => {
        // Update the balance logic here
        setBalance(
            (prevBalance) =>
                prevBalance + (type === "credit" ? amount : -amount)
        );;
    };

    return <Wallet wallet={{ balance }} updateBalance={updateBalance} />;
}
