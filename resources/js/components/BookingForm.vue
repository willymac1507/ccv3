<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const model = defineModel<string>();
</script>

<template>
    <Dialog>
        <form>
            <DialogTrigger as-child>
                <button class="btn btn-primary"> Book </Button>
            </DialogTrigger>
            <DialogContent class="sm:max-w-106.25">
                <DialogHeader>
                    <DialogTitle>Edit profile</DialogTitle>
                    <DialogDescription>
                        Make changes to your profile here. Click save when
                        you're done.
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4">
                    <div class="grid gap-3">
                        <Label for="name-1">Name</Label>
                        <Input
                            id="name-1"
                            v-model="model"
                            default-value="Pedro Duarte"
                            name="name"
                        />
                    </div>
                    <div class="grid gap-3">
                        <Label for="username-1">Username</Label>
                        <Input
                            id="username-1"
                            default-value="@peduarte"
                            name="username"
                        />
                    </div>
                </div>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button variant="outline"> Cancel </Button>
                    </DialogClose>
                    <Button type="submit"> Save changes </Button>
                </DialogFooter>
            </DialogContent>
        </form>
    </Dialog>
</template>
