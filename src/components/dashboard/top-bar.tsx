"use client"

import React, { useState } from "react"
import { useParams, usePathname, useRouter } from "next/navigation"
import { getUserData } from "@/api/helpers/get-me"
import { Avatar, Group, Menu, rem, Text, UnstyledButton } from "@mantine/core"
import { IconChevronDown, IconLogout } from "@tabler/icons-react"
import cx from "clsx"
import { signOut, useSession } from "next-auth/react"

import { userData } from "@/types/login-response"

import DynamicSelect from "../ui/dynamic-select"
import classes from "./top-bar.module.css"

type Props = {
  user: userData
}

const TopBar = ({ user }: Props) => {
  const [userMenuOpened, setUserMenuOpened] = useState(false)
  const handleLogout = async () => {
    signOut()
  }

  const session = useSession()!
  const { association_id } = useParams() as {
    association_id: string
  }

  const router = useRouter()
  const pathName = usePathname()
  return (
    <header className="fixed inset-x-0 right-[60px] top-0 z-[10] bg-white  shadow  md:right-20">
      <div>
        <div className="flex justify-end gap-3 px-2 py-2  md:gap-4 md:px-8">
          <div className=" flex  items-center gap-3">
            <span className="max-md:hidden">تغير الجمعية</span>

            <DynamicSelect
              queryFn={async () => {
                return await getUserData()
              }}
              queryKey="userData"
              placeholder="اختر جمعية"
              formatData={(data) => {
                const associations = data?.data.associations.map(
                  (element, index) => {
                    return { value: element.id + "", label: element.name }
                  },
                )
                return associations
              }}
              value={association_id}
              allowDeselect={false}
              onChange={(_value, option) =>
                router.push(pathName.replace(association_id, _value!))
              }
              size="xs"
            />
          </div>
          <Menu
            width={260}
            position="bottom-end"
            transitionProps={{ transition: "pop-top-right" }}
            onClose={() => setUserMenuOpened(false)}
            onOpen={() => setUserMenuOpened(true)}
            withinPortal>
            <Menu.Target>
              <UnstyledButton
                className={cx(classes.user, {
                  [classes.userActive]: userMenuOpened,
                })}>
                <Group className=" flex-nowrap" gap={7}>
                  <Avatar src={user.avatar} alt={user.name} radius="xl" size={20} />
                  <Text fw={500} className=" text-xs md:text-sm" lh={1} mr={3}>
                    {user.name}
                  </Text>
                  <IconChevronDown
                    style={{ width: rem(12), height: rem(12) }}
                    stroke={1.5}
                  />
                </Group>
              </UnstyledButton>
            </Menu.Target>
            <Menu.Dropdown className="!w-[160px] lg:!w-[210px]">
              {/* <Menu.Label>خيارات</Menu.Label>
              <Menu.Item
                leftSection={
                  <IconStar
                    style={{ width: rem(16), height: rem(16) }}
                    color={theme.colors.yellow[6]}
                    stroke={1.5}
                  />
                }>
                خيار
              </Menu.Item>
              <Menu.Item
                leftSection={
                  <IconMessage
                    style={{ width: rem(16), height: rem(16) }}
                    color={theme.colors.blue[6]}
                    stroke={1.5}
                  />
                }>
                خيار
              </Menu.Item>
              <Menu.Divider /> */}
              {/* <Menu.Item
                leftSection={
                  <IconSwitchHorizontal
                    style={{ width: rem(16), height: rem(16) }}
                    stroke={1.5}
                  />
                }>
                تبديل الحساب
              </Menu.Item> */}
              <Menu.Item
                onClick={handleLogout}
                leftSection={
                  <IconLogout
                    style={{ width: rem(16), height: rem(16) }}
                    stroke={1.5}
                  />
                }>
                تسجيل الخروج
              </Menu.Item>
            </Menu.Dropdown>
          </Menu>
        </div>
      </div>
    </header>
  )
}

export default TopBar
