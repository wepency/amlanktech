"use client"

import React, { useState } from "react"
import { ScrollArea, Table } from "@mantine/core"
import { useMediaQuery } from "@mantine/hooks"
import cx from "clsx"

import classes from "./table-scroll-area.module.css"

type Props<T, L> = {
  data: T[]
  renderRows: (element: T, index: number) => React.ReactNode
  headerData: L[]
  renderTableHeader: (element: L, index: number) => React.ReactNode
  height?: number | "auto"
  minWidth?: number
}

export function TableScrollArea<T, L>({
  data,
  renderRows,
  headerData,
  renderTableHeader,
  height = 300,
  minWidth = 700,
}: Props<T, L>) {
  const [scrolled, setScrolled] = useState(false)
  const matches = useMediaQuery("(max-width: 786px)")
  if (height === "auto") {
    return (
      <ScrollArea.Autosize type={matches ? "never" : "hover"} mah={700}>
        <Table striped highlightOnHover withTableBorder miw={minWidth}>
          <Table.Thead
            className={cx(classes.header, { [classes.scrolled]: scrolled })}>
            <Table.Tr>{headerData.map(renderTableHeader)}</Table.Tr>
          </Table.Thead>
          <Table.Tbody>{data.map(renderRows)}</Table.Tbody>
        </Table>
      </ScrollArea.Autosize>
    )
  }
  return (
    <ScrollArea
      type={matches ? "never" : "hover"}
      h={height}
      onScrollPositionChange={({ y }) => setScrolled(y !== 0)}>
      <Table striped highlightOnHover withTableBorder miw={minWidth}>
        <Table.Thead
          className={cx(classes.header, { [classes.scrolled]: scrolled })}>
          <Table.Tr>{headerData?.map(renderTableHeader)}</Table.Tr>
        </Table.Thead>
        <Table.Tbody>{data?.map(renderRows)}</Table.Tbody>
      </Table>
    </ScrollArea>
  )
}
