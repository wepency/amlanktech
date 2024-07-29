"use client"

import { useState } from "react"
import Image from "next/image"
import Link from "next/link"
import { useParams, usePathname } from "next/navigation"
import { logo } from "@/assets"
import { Button, Center, rem, Stack, Tooltip, UnstyledButton } from "@mantine/core"
import {
  IconArchive,
  IconBrandZoom,
  IconBuildingCommunity,
  IconChartArrowsVertical,
  IconHeartHandshake,
  IconHome2,
  IconLicense,
  IconLogout,
  IconNews,
  IconReport,
  IconSitemap,
} from "@tabler/icons-react"
import { signOut } from "next-auth/react"

import classes from "./side-bar.module.css"

interface NavbarLinkProps {
  icon: typeof IconHome2
  label: string
  active?: boolean
  link: string
}

function NavbarLink({ icon: Icon, label, active, link }: NavbarLinkProps) {
  const params = useParams()
  return (
    <Tooltip label={label} position="right" transitionProps={{ duration: 0 }}>
      <UnstyledButton
        href={`/dashboard/${params.association_id}${link}`}
        component={Link}
        className={classes.link}
        data-active={active || undefined}>
        <Icon style={{ width: rem(20), height: rem(20) }} stroke={1.5} />
      </UnstyledButton>
    </Tooltip>
  )
}

const data = [
  { link: "", icon: IconHome2, label: "الرئيسية" },
  { link: "/meetings", icon: IconBrandZoom, label: "الاجتماعات" },
  { link: "/units", icon: IconBuildingCommunity, label: "الوحدات" },
  { link: "/tickets", icon: IconReport, label: "طلباتي" },
  { link: "/permits", icon: IconLicense, label: "التصاريح" },
  { link: "/subscriptions", icon: IconHeartHandshake, label: "الاشتراكات" },
  { link: "/posts", icon: IconNews, label: "المنشورات" },
  { link: "/polls", icon: IconChartArrowsVertical, label: "التصويت" },
  { link: "/system-documents", icon: IconArchive, label: "السجلات" },
  { link: "/association-system", icon: IconSitemap, label: "نظام الجمعية" },
]

export function SideBar() {
  const pathName = usePathname()
  const params = useParams()

  const links = data.map((link, index) => (
    <NavbarLink
      {...link}
      key={link.label}
      active={
        link.link === ""
          ? pathName === `/dashboard/${params.association_id}`
          : pathName.includes(link.link)
      }
    />
  ))

  const handleLogout = async () => {
    signOut()
  }

  return (
    <nav className={classes.navbar + " fixed right-0 top-0 bg-white"}>
      <Center component={Link} href={`/dashboard`}>
        <Image src={logo} alt="logo" className={"w-40"} />
      </Center>

      <div className={classes.navbarMain}>
        <Stack justify="center" gap={0}>
          {links}
        </Stack>
      </div>

      <Stack justify="center" gap={0} className="mt-auto">
        <Tooltip
          label={"تسجيل الخروج"}
          position="right"
          transitionProps={{ duration: 0 }}>
          <UnstyledButton onClick={handleLogout} className={classes.link}>
            <IconLogout
              style={{ width: rem(20), height: rem(20) }}
              className="text-red-600"
              stroke={1.5}
            />
          </UnstyledButton>
        </Tooltip>
      </Stack>
    </nav>
  )
}
