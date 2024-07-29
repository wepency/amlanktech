import React from "react"

type Props = {
  error?: Error | null
  message: string
}

const Error = ({ error, message }: Props) => {
  return !!message ? (
    <div className="grow text-center text-sm font-semibold text-red-600">
      <p>{message}</p>
      <span className="font-base mt-4 block text-[10px]">
        {error?.message || ""}
      </span>
    </div>
  ) : null
}

export default Error
