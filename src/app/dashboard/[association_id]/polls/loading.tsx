import React from "react"
import { Loader } from "@mantine/core"

type Props = {}

const loading = (props: Props) => {
  return (
    <div className="flex h-[calc(100vh-200px)] items-center justify-center">
      <Loader size={"lg"} />
    </div>
  )
}

export default loading
