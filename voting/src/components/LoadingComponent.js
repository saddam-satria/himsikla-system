import React from "react"

const LoadingComponent = () => {
    return (
        <div className="fixed left-0 top-0 z-10 h-screen w-screen">
            <div className="flex flex-col space-y-2 justify-center h-full w-full items-center">
                <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRL2tq0IANwwvpD-dJ-YD8Zbe0Xeriw2h-mdw&usqp=CAU"
                    alt="circle loading"
                    className="w-36 h-36 object-contain"
                />
                <span className="text-sm capitalize">tunggu sebentar</span>
            </div>
        </div>
    )
}

export default LoadingComponent