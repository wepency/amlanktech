"use client"

import Image from "next/image"
import Link from "next/link"
import { logo } from "@/assets"
import {
  Box,
  Burger,
  Button,
  Divider,
  Drawer,
  Group,
  rem,
  ScrollArea,
} from "@mantine/core"
import { useDisclosure } from "@mantine/hooks"

import classes from "./HeaderMegaMenu.module.css"

export function Header() {
  const [drawerOpened, { toggle: toggleDrawer, close: closeDrawer }] =
    useDisclosure(false)

  return (
    <Box>
      <header className={classes.header}>
        <Group justify="space-between" h="100%">
          <Link href={"/"} className=" md:w-[200px]">
            <Image src={logo} alt="logo" className="w-[50px]" />
          </Link>

          <Group h="100%" gap={0} visibleFrom="sm">
            <a href="#" className={classes.link}>
              الرئيسية
            </a>
            <a href="#pricing" className={classes.link}>
              الباقات
            </a>
            <a href="#contact-us" className={classes.link}>
              تواصل معنا
            </a>
          </Group>

          <Group visibleFrom="sm">
            <Button component={Link} href={"/login"} variant="default">
              تسجيل الدخول
            </Button>
            <Button component={Link} href={"/register"}>
              إنشاء حساب
            </Button>
          </Group>

          <Burger opened={drawerOpened} onClick={toggleDrawer} hiddenFrom="sm" />
        </Group>
      </header>

      <Drawer
        opened={drawerOpened}
        onClose={closeDrawer}
        size="100%"
        padding="md"
        title="Navigation"
        hiddenFrom="sm"
        zIndex={1000000}>
        <ScrollArea h={`calc(100vh - ${rem(80)})`} mx="-md">
          <Divider my="sm" />

          <a href="#" onClick={toggleDrawer} className={classes.link}>
            الرئيسية
          </a>

          <a href="#pricing" onClick={toggleDrawer} className={classes.link}>
            الباقات
          </a>
          <a href="#contact-us" onClick={toggleDrawer} className={classes.link}>
            تواصل معنا
          </a>

          <Divider my="sm" />

          <Group justify="center" grow pb="xl" px="md">
            <Button component={Link} href={"/login"} variant="default">
              تسجيل الدخول
            </Button>
            <Button component={Link} href={"/register"}>
              إنشاء حساب
            </Button>
          </Group>
        </ScrollArea>
      </Drawer>
    </Box>
  )
}
