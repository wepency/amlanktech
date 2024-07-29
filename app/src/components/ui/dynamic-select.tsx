"use client"

import React, { ElementRef, forwardRef } from "react"
import { useParams } from "next/navigation"
import { Select, SelectProps } from "@mantine/core"
import { IconLoader2 } from "@tabler/icons-react"
import { useQuery } from "@tanstack/react-query"

type DynamicSelectProps<T> = {
  queryKey: string
  formatData: (data: T) => { value: string; label: string }[]
  queryFn: () => Promise<T>
  error?: string
} & Omit<SelectProps, "data">

const DynamicSelect = <T,>(
  props: DynamicSelectProps<T>,
  ref: React.Ref<ElementRef<"input">>,
) => {
  const { queryKey, queryFn, error, formatData, ...selectProps } = props

  const { association_id } = useParams() as { association_id: string }
  const {
    data,
    isLoading,
    error: responseError,
  } = useQuery({
    queryKey: ["lists", association_id, queryKey],
    queryFn: queryFn,
  })

  const formattedData = data ? formatData(data) : []

  return (
    <Select
      rightSection={
        isLoading ? <IconLoader2 stroke={1.5} className="animate-spin" /> : null
      }
      disabled={isLoading}
      data={formattedData}
      error={error || (responseError ? responseError.message : undefined)}
      {...selectProps}
      ref={ref}
    />
  )
}

export default forwardRef(DynamicSelect) as <T>(
  props: DynamicSelectProps<T> & { ref?: React.Ref<ElementRef<"input">> },
) => ReturnType<typeof DynamicSelect>
